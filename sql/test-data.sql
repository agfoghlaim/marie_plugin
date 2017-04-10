INSERT INTO `wp_bookings` (`guest_id`, `checkin`,  `room_no`,`room_type_requested`,`no_adults`,`no_children`,`checkout`) VALUES
( 1, '2017-02-26', 101, NULL, NULL, NULL, '2017-03-01'),
( 2, '2017-03-04', 101, NULL, NULL, NULL, '2017-03-05'),
( 3, '2017-03-17', 101, NULL, NULL, NULL, '2017-03-18'),
( 4, '2017-04-02', 101, NULL, NULL, NULL, '2017-04-05'),
( 5, '2017-04-07', 101, NULL, NULL, NULL, '2017-04-09'),
( 6, '2017-04-19', 101, NULL, NULL, NULL, '2017-04-20'),
( 7, '2017-04-23', 101, NULL, NULL, NULL, '2017-04-25'),
( 8, '2017-06-13', 101, NULL, NULL, NULL, '2017-06-16'),
( 9, '2017-02-26', 102, NULL, NULL, NULL, '2017-03-01'),
(10, '2017-03-04', 102, NULL, NULL, NULL, '2017-03-05'),
(11, '2017-03-12', 102, NULL, NULL, NULL, '2017-03-14'),
(12, '2017-03-17', 102, NULL, NULL, NULL, '2017-03-18'),
(13, '2017-04-04', 102, NULL, NULL, NULL, '2017-04-07'),
(14, '2017-04-20', 102, NULL, NULL, NULL, '2017-04-21'),
(15, '2017-04-23', 102, NULL, NULL, NULL, '2017-04-25'),
(16, '2017-03-16', 103, NULL, NULL, NULL, '2017-03-18'),
(17, '2017-04-06', 103, NULL, NULL, NULL, '2017-04-08'),
(18, '2017-04-21', 103, NULL, NULL, NULL, '2017-04-22'),
(19, '2017-04-23', 103, NULL, NULL, NULL, '2017-04-25'),
(20, '2017-03-17', 104, NULL, NULL, NULL, '2017-03-19'),
(21, '2017-04-07', 104, NULL, NULL, NULL, '2017-04-08'),
(22, '2017-04-18', 104, NULL, NULL, NULL, '2017-04-19'),
(23, '2017-04-23', 104, NULL, NULL, NULL, '2017-04-25'),
(30, '2017-05-23', 104, NULL, NULL, NULL, '2017-05-24'),
(120, '2017-03-18', 101, NULL, NULL, NULL, '2017-03-19'),
(132, '2017-03-18', 102, NULL, NULL, NULL, '2017-03-19'),
(133, '2017-03-18', 103, NULL, NULL, NULL, '2017-03-19');


INSERT INTO `wp_guests` (`guest_id`, `fname`, `lname`, `email`, `address`, `country`, `postcode`, `phone`, `no_adults`, `no_children`, `arrival`) VALUES
(1, 'marie', 'ohara', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'hi', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'hi', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'blah', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'monday', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'monday', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'the', 'php', 'has@email.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'the', 'php', 'has@email.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'the', 'php', 'has@email.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'the', 'php', 'has@email.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'why', 'is', 'this', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'why', 'is', 'this', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'why', 'is', 'this', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'why', 'is', 'this', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'why', 'is', 'this', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'd', 'd', 'd', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'ma', 'oh', 'm@marie.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'donald', 'trump', 'iruleok@potus.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL);



INSERT INTO `wp_rooms` (`rm_id`, `rm_type`, `max_occup`, `amt_per_night`, `rm_type_id`, `actual_rm_no` ) VALUES
(83, 'single', 1, '50', 1, 101),
(82, 'double', 2, '60', 2, 102),
(79, 'double', 2, '60', 2, 103),
(85, 'family', 4, '80', 4, 104);



INSERT INTO `wp_room_type` (`rm_type_id`, `description`, `post_id_wp`) VALUES
(1, 'double', 136),
(2, 'single', 137),
(3, 'family', 138);
