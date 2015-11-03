
--
-- Table structure for table `holdem_hand`
--

CREATE TABLE `holdem_hand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_id` int(11) DEFAULT NULL,
  `community_cards` text,
  `currentDeck` text,
  `pots` text,
  `current_bet` int(11) DEFAULT NULL,
  `current_state` int(11) DEFAULT NULL,
  `dealer_position` int(11) DEFAULT NULL,
  `blind_position` int(11) DEFAULT NULL,
  `last_time` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holdem_hand_palyer`
--

CREATE TABLE `holdem_hand_palyer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `nick_name` varchar(32) DEFAULT NULL,
  `table_stack` int(11) DEFAULT NULL,
  `pocket_cards` varchar(255) DEFAULT NULL,
  `pots_share` text,
  `current_share` int(11) DEFAULT NULL,
  `current_state` int(11) DEFAULT NULL,
  `wait_start_time` bigint(20) DEFAULT NULL,
  `table_position` int(11) DEFAULT NULL,
  `win_html` text,
  `act_times` int(11) DEFAULT '0',
  `last_request_time` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holdem_table`
--

CREATE TABLE `holdem_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numberof_players` int(11) DEFAULT NULL,
  `bet_limit` int(11) DEFAULT NULL,
  `initial_stake` int(11) DEFAULT NULL,
  `minimum_bet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(24) DEFAULT NULL,
  `edate` bigint(15) DEFAULT NULL,
  `login` varchar(128) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `notify` varchar(1) DEFAULT 'Y',
  `deck` blob,
  `cur_hand` varchar(255) DEFAULT '',
  `win_hand` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `edate` bigint(15) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `game` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
