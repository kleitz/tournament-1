
DROP TABLE IF EXISTS `{prefix}seasons_teams`;

CREATE TABLE `{prefix}seasons_teams` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`season_id` int(11) NOT NULL,
	`team_id` int(11) NOT NULL,
	`isReady` smallint(6) NOT NULL DEFAULT '0',
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `season_id` (`season_id`),
	KEY `team_id` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;