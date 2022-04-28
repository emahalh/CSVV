import os  # system os for accessing directory
from datetime import datetime, date  # time reading
import cv2  # accessing  the camera and detact face
import mysql.connector  # database connection
from flask import Flask, Response, request, jsonify  # Response is responsible for sending data to web
# request - receiving data and request from web and jsonify -- it's a convert data to JSON
from flask_cors import CORS, cross_origin  # for http or web request security reason

app = Flask(__name__)
CORS(app)

video_capture = cv2.VideoCapture(0)
recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read('trainer/trainer.yml')
font = cv2.FONT_HERSHEY_SIMPLEX
stop_key = ""
student_id = ""


def gen():
    # this for detect face
    face_cascade = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')
    while True:
        global student_id
        ret, image = video_capture.read()
        # grayscale image (it's small size more understandable by the face recognition algorithm )
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        faces = face_cascade.detectMultiScale(gray, 1.1, 6)
        for (x, y, w, h) in faces:
            # draw rectangle
            cv2.rectangle(image, (x, y), (x + w, y + h), (0, 255, 0), 2)
            # matching (recognize the face)
            # stduent_id mean whose face
            # confidence mean accuracy (40%-55%)
            student_id, confidence = recognizer.predict(gray[y:y + h, x:x + w])

            # Check if confidence is less them 100 ==> "0" is perfect match
            if round(confidence) < 90:
                # # capture automatically image here
                # now = datetime.now()
                # image_file = "shot_{}.png".format(str(now).replace(":", ''))
                # p = os.path.sep.join(['C:\\xampp\\htdocs\\CSVV\\shots\\', image_file])
                # cv2.imwrite(p, image)

                confidence = "  {0}%".format(round(100 - confidence))
                db = mysql.connector.connect(
                    host="localhost",
                    user="root",
                    passwd="",
                    database="csvv_db"
                )
                cursor = db.cursor()
                cursor.execute("SELECT * FROM student_table WHERE Student_ID = %s", (student_id,))
                result = cursor.fetchall()
                if result:
                    # this code for write name above the rectangle
                    cv2.putText(image, str(result[0][1]), (x + 5, y - 5), font, 1, (255, 255, 255), 2)
                    cv2.putText(image, str(confidence), (x + 5, y + h - 5), font, 1, (255, 255, 0), 1)
                cursor.close()
            else:
                student_id = "unknown"
                confidence = "  {0}%".format(round(100 - confidence))
        # controller of Start and stop button
        if stop_key == 'Stop':
            cv2.waitKey(1)
            break;
        if stop_key == 'Start':
            cv2.waitKey(-1)
        # connect to the database
        # pass id and find the student
        # print his/her name

        cv2.imwrite('t.jpg', image)
        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + open('t.jpg', 'rb').read() + b'\r\n')
    video_capture.release()

    return result

# Record information in event table
@app.route('/add_event', methods=['POST', 'GET'])
@cross_origin()
def add_event():
    db = mysql.connector.connect(
        host="localhost",
        user="root",
        passwd="",
        database="csvv_db"
    )

    if request.method == 'POST':
        Stud_Access_Status = request.form['Stud_Access_Status']
        Sys_Status = request.form['Sys_Status']
        Alarm = request.form['Alarm']
        Notification = request.form['Notification']

        std_id = ""
        db_time = ""
        if student_id:
            cursor = db.cursor()

            cursor.execute("SELECT eventtype_table.Student_ID, log_table.Attend_Date FROM log_table INNER JOIN eventtype_table ON eventtype_table.Student_ID = log_table.Student_ID")
            atd_records = cursor.fetchall()
            for row in atd_records:
                std_id = str(row[0])
                db_time = row[1]
            cursor.close()
            if student_id != std_id :
                cursor_event = db.cursor()
                add_attendance = '''INSERT INTO eventtype_table(Stud_Access_Status, Sys_Status, Alarm, Notification, Student_ID) VALUES (%s,%s,%s,%s,%s)'''
                sql_data = (Stud_Access_Status, Sys_Status, Alarm, Notification, student_id)
                cursor_event.execute(add_attendance, sql_data)
                cursor_event.close()
            db.commit()
    return Response('ok')

# Record Attendance in log_table
@app.route('/take_attendance', methods=['POST', 'GET'])
@cross_origin()
def take_attendance():
    db = mysql.connector.connect(
        host="localhost",
        user="root",
        passwd="",
        database="csvv_db"
    )
    std_id = ""
    db_time = ""
    if student_id:
        cursor = db.cursor()
        cursor.execute("SELECT * FROM log_table WHERE Student_ID = %s", (student_id,))
        atd_records = cursor.fetchall()
        for row in atd_records:
            std_id = str(row[4])
            db_time = row[2]
        if student_id != std_id and db_time != date.today():
            add_attendance = '''INSERT INTO log_table(Student_ID, Attend_Date) VALUES (%s,%s)'''
            sql_data = (student_id, date.today())
            cursor.execute(add_attendance, sql_data)

        db.commit()
        cursor.close()
    return Response('ok')

# to capture snap of recognized face and save it into shots folder
@app.route('/image_capture', methods=['POST', 'GET'])
@cross_origin()
def image_capture():
    ret, image = video_capture.read()
    now = datetime.now()
    image_file = "shot_{}.png".format(str(now).replace(":", ''))
    p = os.path.sep.join(['C:\\xampp\\htdocs\\CSVV\\shots\\', image_file])
    cv2.imwrite(p, image)
    return Response(image_file)


# Current Student data if register
@app.route('/get_current_student_data', methods=['POST', 'GET'])
@cross_origin()
def get_current_student_data():
    global student_info
    if student_id == 'unknown':
        return jsonify(student_id)
    else:
        db = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="",
            database="csvv_db"
        )
        cursor = db.cursor()
        cursor.execute("SELECT * FROM student_table WHERE Student_ID = %s", (student_id,))
        result = cursor.fetchall()
        for stDt in result:
            student_info = {
                'Student_ID': stDt[0],
                'Student_Name': stDt[1],
                'Age': stDt[2],
                'Height': stDt[3],
                'Width': stDt[4],
                'Vaccine_Status': stDt[5],
                'Doses_Count': stDt[6],
                'School_Lvl': stDt[7],
                'Parent_Name': stDt[8],
                'Parents_Contact_No': stDt[9]
            }
        return jsonify(student_info)  # here we are converting data into JSON

# Start/Stop feature that control face detection and recognition 
@app.route('/requests', methods=['POST', 'GET'])
def tasks():
    global stop_key
    global video_capture
    if request.method == 'POST':
        ret, image = video_capture.read()
        # This is for manual capture button
        if request.form['click'] == 'Capture':
            now = datetime.now()
            image_file = "shot_{}.png".format(str(now).replace(":", ''))
            p = os.path.sep.join(['C:\\xampp\\htdocs\\CSVV\\shots\\', image_file])
            cv2.imwrite(p, image)
            return Response(image_file)
        if request.form['click'] == 'Stop':
            stop_key = 'Stop'
            return Response('stopped')
        if request.form['click'] == 'Start':
            stop_key = 'Start'
            video_capture = cv2.VideoCapture(0)
            gen()
            return Response('started')
    return Response('ok')

# Video streaming in guard page
@app.route('/video_feed')
def video_feed():
    """Video streaming route. Put this in the src attribute of an img tag."""
    return Response(gen(),
                    mimetype='multipart/x-mixed-replace; boundary=frame')


if __name__ == '__main__':
    app.run()
