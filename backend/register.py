import time
import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector


db = mysql.connector.connect(
  host="localhost",
  user="username",
  passwd="password",
  database="your_database"
)

cursor = db.cursor()
reader = SimpleMFRC522()

try:
  while True:
    print('Tempelkan kartu untuk mendaftar')
    id, text = reader.read()
    cursor.execute(f'SELECT nama,id FROM t_murid WHERE rfid_uid={str(id)}')
    result = cursor.fetchone()
    print(result)

    if cursor.rowcount >= 1:
      print(f'Kartu anda telah terdaftar dengan nama {result[0]}, dan dengan id {result[1]}\nOverwrite user diatas?')
      overwrite = input('Overwite (Y/N)? ')
      if overwrite[0] == 'Y' or overwrite[0] == 'y':
        print('user telah dioverwrite')
        time.sleep(1)
        sql_insert = f'UPDATE t_murid SET nama = %s, jurusan_dan_kelas= %s WHERE rfid_uid=%s'
      else:
        continue;
    else:
      sql_insert = 'INSERT INTO t_murid (nama, jurusan_dan_kelas, rfid_uid) VALUES (%s, %s, %s)'


    print('Masukkan nama lengkap anda')
    new_name = input("Nama: ")
    print('Masukkan jurusan dan kelas anda contoh = XII TKJ 1')
    jurusan = input('Jurusan: ')

    cursor.execute(sql_insert, (new_name, jurusan, id))

    db.commit()

    print(f'Data anda telah disimpan {new_name}!')
    time.sleep(2)
except KeyboardInterrupt:
  GPIO.cleanup()
finally:
  GPIO.cleanup()
