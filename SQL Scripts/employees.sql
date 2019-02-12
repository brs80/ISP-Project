CREATE TABLE `ISP_mar64`.`employees` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(30),
  `lastName` VARCHAR(30),
  `shortName` VARCHAR(30) NOT NULL,
  `email` VARCHAR(50),
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB;