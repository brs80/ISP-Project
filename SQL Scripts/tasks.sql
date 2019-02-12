CREATE TABLE `ISP_mar64`.`tasks` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `project` INTEGER UNSIGNED NOT NULL,
  `taskDescription` LONGTEXT,
  `respEmployee` INTEGER UNSIGNED,
  `completed` BOOLEAN NOT NULL,
  `startDate` DATE,
  `endDate` DATE,
  `completedDate` DATE,
  `comments` LONGTEXT,
  PRIMARY KEY (`id`)
)