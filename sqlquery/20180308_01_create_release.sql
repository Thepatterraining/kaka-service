CREATE TABLE `sys_applicationrelease` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int(11) DEFAULT NULL,
  `application_guid` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `application_version` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `application_releasenote` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `application_compatible` int(11) DEFAULT NULL,
  `application_dowloadurl` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `application_filehash` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `application_releasedate` datetime not null,
  `created_at` datetime DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;