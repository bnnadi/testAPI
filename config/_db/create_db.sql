CREATE DATABASE `the_database` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `api_logs` (
  `api_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `api_log_user_serialized` varchar(255) DEFAULT NULL,
  `api_log_get_serialized` varchar(255) DEFAULT NULL,
  `api_log_post_serialized` varchar(255) DEFAULT NULL,
  `api_log_files_serialized` varchar(255) DEFAULT NULL,
  `api_log_server_serialized` varchar(255) DEFAULT NULL,
  `api_log_response_serialized` varchar(255) DEFAULT NULL,
  `api_log_date_created` datetime DEFAULT NULL,
  `api_log_date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`api_log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE `scores` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `score_uid` varchar(45) DEFAULT NULL,
  `score_value` varchar(45) DEFAULT NULL,
  `score_visible` tinyint(4) DEFAULT NULL,
  `score_created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fb_id` varchar(45) DEFAULT NULL,
  `user_expires` varchar(45) DEFAULT NULL,
  `user_oauth_token` varchar(45) DEFAULT NULL,
  `user_created_date` datetime DEFAULT NULL,
  `user_visible` tinyint(4) DEFAULT '1',
  `user_country` varchar(45) DEFAULT NULL,
  `user_min_age` int(11) DEFAULT NULL,
  `user_issued_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
