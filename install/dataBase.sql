SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `BlueStats_config` (
`row_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `option` varchar(64) NOT NULL,
  `plugin` varchar(64) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `BlueStats_players` (
`row_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `uuid` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `plugin` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `BlueStats_server` (
`row_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `option` varchar(64) NOT NULL,
  `value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `BlueStats_config`
 ADD PRIMARY KEY (`row_id`);

ALTER TABLE `BlueStats_players`
 ADD PRIMARY KEY (`row_id`);

ALTER TABLE `BlueStats_server`
 ADD PRIMARY KEY (`row_id`);

ALTER TABLE `BlueStats_config`
MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;

ALTER TABLE `BlueStats_players`
MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `BlueStats_server`
MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;
