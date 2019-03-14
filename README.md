# service.kokostudio.net
โปรแกรม eservice สำหรับงาน it ที่ต้องดูแล user จำนวนมาก ๆ โดยที่ user สามารถแจ้งปัญหาผ่านทางระบบ และ จะมีการแจ้งไปถึงผู้ที่เกี่ยวข้อง ทาง line notify ทำให้เจ้าหน้าที่ it สามารถทราบการแจ้งเตือนได้ทันทีที่มีการแจ้งเข้ามา 
-----
ระบบพัฒนาด้วยภาษา PHP 
-----
ซึ่งผมได้นำมาพัฒนาต่อ จากคุณ @ɴäʍ ให้เหมาะกับสมาชิกในกลุ่ม thaiadmin.org หลายท่าน 
  ความสามารถของโปรแกรม(ส่วนเพิ่ม)
1.เพิ่มสมัครสมาชิก
2.เพิ่มการอนุมัติ
3.เพิ่มการประเมิน
4.เพิ่มสาขา สามารถทำให้ line notify เด้งแยกสาขาได้
5.เพิ่มผู้ดำเนินการ/แผนกรับบริการ/ผู้รับดำเนินการ
6.เพิ่มจำนวนวันที่ดำเนินการ
-----
วิธีการติดตั้ง
1. ใช้ database kokostudio_eservice.sql
2. user=admin password=123456
-----
update 13/3/2019
-----
แก้ปัญหา ปิดสถานะสาขา แล้วยังแสดงอยู่
- request.php
- function.php
-----
update 8/3/2019
-----
เพิ่มการประเมิน การดำเนินการ
- เพิ่ม field req_rating ใน table ex_request
- request.php
- manage.php
-----
update 7/3/2019
-----
แก้ไข แสดงผู้รับดำเนินการ
- request.php
- manage.php
-----
update 6/3/2019
-----
แก้ไข database kokostudio_eservice.sql ใช้งานไม่ได้
- kokostudio_eservice.sql
-----
update 28/2/2019
-----
แก้ไข กรณี upload รูปไม่ได้ตอน update
- request_manage.php

เพิ่มจำนวนวันในการดำเนินการ
- function.php
- request.php
- manage.php
- report_request.php
- report_excel.php

แก้ปัญหารายงาน ไม่แสดง ผู้ดำเนินการ
- print.php

แก้ไข ปัญหา สถานะปิด ไม่ให้แสดง
- request.php
- manage.php
- service.php
- getservice.php
-----
update 17/1/2019
-----
แก้ปัญหา 
- user ชอบโทรแจ้งงาน ไม่ถนัดใช้ app
- it รับเรื่อง และจะเป็นผู้บันทึกลงระบบเอง 
- พร้อมกำหนดผู้รับผิดชอบ
- แก้ปัญหาเสร็จ ก็ดำเนินการเอง
- กรณีต้องให้ผู้มีอำนาจในการสั่งซื้อ หรือ ซ่อม สามารถเลือกให้ผู้นั้นอนุมัติการ ซื้่อ หรือ ซ่อมได้
- เสร็จ
-----
20/12/2018
-----
modifi eservice by kokostudio
- ใช้ database kokostudio_eservice.sql 
- user=admin password=123456
