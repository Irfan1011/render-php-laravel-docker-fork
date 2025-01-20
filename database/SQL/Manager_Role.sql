INSERT INTO `role_user`(`role_id`, `user_id`, `user_type`) VALUES ('5','1','App\\Models\\User');

INSERT INTO `car` (`name`,`photo`,`type`,`transmission_type`,`fuel_type`,`color`,`trunk_volume`,`facility`,`daily_price`,`license_plate`,`status`)
VALUES ('Toyota New Vios','Toyota New Vios.jpg','Sedan','AT','Pertamax','Red','0','AC + Safety Bag','400000','AB 1011 AB','Null'),
('Honda Civic','Honda Civic.jpg','Sedan','AT','Pertamax','Grey','0','AC + Multimedia + Honda Sensing Safety','500000','AB 1235 CS','Null'),
('Toyota New Agya','Toyota New Agya.jpg','City Car','AT','Pertalite','Red','0','AC + Air Bag','250000','AD 3451 BB','Null'),
('Honda Brio','Honda Brio.jpg','City Car','MT','Pertalite','White','0','AC + Air Bag','200000','AB 5631 DH','Null'),
('Toyota Rush','Toyota Rush.jpg','SUV','AT','Pertamax','White','0','AC + Air Bag','1000000','AB 8973 DE','Null'),
('Toyota Fortuner','Toyota Fortuner.jpg','SUV','AT','Pertamax','Black','0','AC + Air Bag + Safety System','1250000','AD 7812 EF','Null'),
('Toyota New Avanza','Toyota New Avanza.jpg','MPV','CVT','Pertalite','Silver','0','AC + Air Bag + Safety System','300000','AB 9080 CS','Null'),
('Toyota Alphard','Toyota Alphard.jpg','MPV','AT','Pertamax','White','0','AC + Air Bag','1500000','AD 2023 AB','Null');

-- INSERT INTO `users`(`name`, `email`, `password`) 
-- VALUES ('Irfan','Irfan@gmail.com','@Methodist2'),
-- ('abc','abc@gmail.com','@Methodist2'),
-- ('acb','acb@gmail.com','@Methodist2'),
-- ('bac','bac@gmail.com','@Methodist2'),
-- ('bca','bca@gmail.com','@Methodist2'),
-- ('cab','cab@gmail.com','@Methodist2'),
-- ('cba','cba@gmail.com','@Methodist2');

-- INSERT INTO `role_user`(`role_id`, `user_id`, `user_type`) 
-- VALUES('2','2','App\\Models\\User'),
-- ('2','3','App\\Models\\User'),
-- ('2','4','App\\Models\\User'),
-- ('3','5','App\\Models\\User'),
-- ('3','6','App\\Models\\User'),
-- ('3','7','App\\Models\\User'),
-- ('3','8','App\\Models\\User');

-- INSERT INTO `employee`(`photo`, `address`, `birth`, `gender`, `phone`,`user_id`,`verifikasi_admin`) 
-- VALUES ('KUCIR (22).jpg','Babarsari','2023-09-01','Man','087898131821','2','NULL'),
-- ('IJAZAH (22).jpg','abc','2023-09-02','Gilr','081234567890','3','NULL'),
-- ('KUCIR (22).jpg','acb','2023-09-03','Man','080987654321','4','NULL'),
-- ('IJAZAH (22).jpg','bac','2023-09-04','Girl','081234567890','5','NULL'),
-- ('KUCIR (22).jpg','bca','2023-09-05','Man','080987654321','6','NULL'),
-- ('IJAZAH (22).jpg','cab','2023-09-06','Girl','081234567890','7','NULL'),
-- ('KUCIR (22).jpg','cba','2023-09-06','Man','080987654321','8','NULL');