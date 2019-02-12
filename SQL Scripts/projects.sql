CREATE TABLE `ISP_mar64`.`projects` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `clientName` VARCHAR(255),
  `projectDescription` LONGTEXT,
  `projectManager` INTEGER UNSIGNED,
  `projectStatus` INTEGER UNSIGNED,
  `projectType` INTEGER UNSIGNED,
  `dateCreated` DATETIME NOT NULL,
  `dateCompleted` DATETIME,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB;