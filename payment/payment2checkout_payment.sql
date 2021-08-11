SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  `url` varchar(150) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `zopim` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `brands` (`id`, `short_code`, `url`, `email`, `zopim`) VALUES
(1, 'L-MNS', 'https://logomines.com', 'billing@logomines.com', ''),
(2, 'L-LTY', 'https://logoliberty.com', 'billing@logoliberty.com', ''),
(3, 'F-LD', 'https://fictivelogodesign.com', 'billing@fictivelogodesign.com', ''),
(4, 'F-WD', 'https://fictivewebdesign.com', 'billing@fictivewebdesign.com', ''),
(5, 'F-AN', 'https://fictiveanimators.com', 'billing@fictiveanimators.com', ''),
(6, 'L-AVE', 'https://logoavenues.com', 'billing@logoavenues.com', ''),
(7, 'F-ST', 'https://fictivestudios.com', 'billing@fictivestudios.com', ''),
(8, 'W-LSTC', 'https://webilistics.com', 'billing@webilistics.com', ''),
(9, 'V-AP', 'https://vizanimationpros.com', 'billing@vizanimationpros.com', ''),
(10, 'W-DP', 'https://www.websitesdesignpro.com', 'billing@websitesdesignpro.com', ''),
(11, 'E-BWP', 'https://ebookwritingpros.com', 'billing@ebookwritingpros.com', ''),
(12, 'A-BW', 'https://alphabookwriting.com', 'billing@alphabookwriting.com', ''),
(13, 'S-SST', 'https://sixsigmastudios.com', 'billing@sixsigmastudios.com', ''),
(14, 'C-WB', 'https://craftiveweb.com', 'billing@craftiveweb.com', ''),
(15, 'L-MZT', 'https://logomization.com', 'billing@logomization.com', ''),
(16, 'W-MZT', 'https://webmization.com', 'billing@webmization.com', ''),
(17, 'V-MZT', 'https://videomization.com', 'billing@videomization.com', ''),
(18, 'App-MZT', 'https://appmization.com', 'billing@appmization.com', ''),
(19, 'L-MJK', 'https://logomajestick.com', 'billing@logomajestick.com', ''),
(20, 'W-MJK', 'https://webmajestick.com', 'billing@webmajestick.com', ''),
(21, 'V-MJK', 'https://videomajestick.com', 'billing@videomajestick.com', ''),
(22, 'LDO', 'https://logodesignoffice.com', 'billing@logodesignoffice.com', ''),
(23, 'W-DO', 'https://websitedesignoffice.com', 'billing@websitedesignoffice.com', ''),
(24, 'SDO', 'seodesignoffice.com', 'billing@seodesignoffice.com', ''),
(25, 'L-NK', 'https://logonick.com', 'billing@logonick.com', ''),
(26, 'S-PRM', 'https://seopromisers.com', 'billing@seopromisers.com', '<!-- Start of  Zendesk Widget script --> <script id=\"ze-snippet\" src=\"https://static.zdassets.com/ekr/snippet.js?key=4427eb38-086f-499a-a91c-f717d17285c2\"> </script> <!-- End of  Zendesk Widget script -->'),
(27, 'L-PMT', 'https://logoprismatic.com', 'billing@logoprismatic.com', ''),
(28, 'W-PMT', 'https://webprismatic.com', 'billing@webprismatic.com', ''),
(29, 'S-PMT', 'https://seoprismatic.com', 'billing@seoprismatic.com', ''),
(30, 'L-DOC', 'https://logodesignocean.com', 'billing@logodesignocean.com', ''),
(31, 'W-DOC', 'https://websitedesignocean.com', 'billing@websitedesignocean.com', ''),
(32, 'M-VDS', 'https://macvideos.com', 'billing@macvideos.com', ''),
(33, 'W-PPS', 'https://wikipediapros.com', 'billing@wikipediapros.com', ''),
(34, 'L-DFS', 'https://logodesignforsale.com', 'billing@logodesignforsale.com', ''),
(35, 'LDO-A', 'https://logodesignoffice.com.au', 'billing@logodesignoffice.com.au', ''),
(36, 'Apps-N', 'https://appsnado.com', 'billing@appsnado.com', ''),
(37, 'B-MLW', 'https://brandmellow.com', 'billing@brandmellow.com', ''),
(38, 'M-A-S', 'merakiappstudio.com', 'billing@merakiappstudio.com', ''),
(39, 'OIP', 'https://outsourceinpakistan.com', 'billing@outsourceinpakistan.com', ''),
(40, 'CTCOS', 'https://cctvoutsourcing.com', 'billing@cctvoutsourcing.com', ''),
(41, 'DNLLC', 'https://diginadollc.com', 'billing@diginadollc.com', ''),
(42, 'TNDO', 'https://technado.co', 'billing@technado.co', ''),
(43, '-', 'https://orbittechnologiesllc.net', 'billing@orbittechnologiesllc.net', ''),
(44, 'L-IWS', 'https://logoinvinci.com', 'billing@logoinvinci.com', ''),
(45, 'W-IWS', 'https://webinvinci.com', 'billing@webinvinci.com', ''),
(46, 'L-N-A', 'https://logonado.com.au', 'billing@logonado.com.au', ''),
(47, 'W-N-A', 'https://webnado.com.au', 'billing@webnado.com.au', ''),
(48, 'V-N-A', 'https://vidnado.com.au', 'billing@vidnado.com.au', ''),
(49, '-', 'https://videoinc.com.au', 'billing@videoinc.com.au', ''),
(50, 'M-LD-A', 'https://maestrologodesign.com.au', 'billing@maestrologodesign.com.au', ''),
(51, 'B-LGS', 'https://britainlogos.co.uk', 'billing@britainlogos.co.uk', ''),
(52, 'B-VDS', 'https://britainvideos.co.uk', 'billing@britainvideos.co.uk', ''),
(53, 'B-WE', 'https://britainweb.co.uk', 'billing@britainweb.co.uk', ''),
(54, 'A-EV', 'americanexplainervideos.com', 'billing@americanexplainervideos.com', ''),
(55, 'b2beh', 'https://exporthub.com', 'contactus@exporthub.com', ''),
(56, 'b2btk', 'https://tradekey.com', 'contactus@tradekey.com', NULL);

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `ccname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `exp1` varchar(2) NOT NULL,
  `exp2` varchar(2) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(255) NOT NULL,
  `last4digit` varchar(4) NOT NULL,
  `company` varchar(255) NOT NULL,
  `gateway` varchar(255) NOT NULL,
  `officephone` varchar(255) NOT NULL,
  `badip` int(2) DEFAULT NULL,
  `ipcheck` varchar(255) DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payment` (`id`, `customer_id`, `ccname`, `address`, `city`, `country`, `email`, `phone`, `exp1`, `exp2`, `firstname`, `lastname`, `state`, `site`, `date`, `ip`, `last4digit`, `company`, `gateway`, `officephone`, `badip`, `ipcheck`, `payment_status`) VALUES
(1, 'cus_IvS5td68xOgGW2', 'oliver', 'abcd', 'abc', 'UK', 'abc@abc.com', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 09:10:06', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(2, 'cus_IvSAD1icrBL6uJ', 'oliver', 'abcd', 'abc', 'UK', 'hafiz.zeeshan@technado.co', '', '', '', 'oliver', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 09:14:28', '', '4242', 'oliver xyz', 'Stripe', '', NULL, NULL, 0),
(3, 'cus_IvSBApFY7YXSFI', 'oliver', 'abcd', 'abc', 'UK', 'abc@abc.com', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 09:16:05', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(4, 'cus_IvSesUIIucywJg', 'oliver', 'abcd', 'abc', 'UK', 'abc@abc.com', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 09:44:53', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(5, 'cus_IvSirAhcyxaXXB', 'oliver', '13450 Farmcrest Ct', 'Herndon', 'US', 'hafiz.zeeshan@technado.co', '', '', '', 'abcd', 'xyz', 'VA', 'MYPAYMENT', '2021-02-11 09:49:16', '', '4242', 'abcd xyz', 'Stripe', '', NULL, NULL, 0),
(6, 'cus_IvSki7d0aLLN6l', 'oliver', 'abcd', 'abc', 'UK', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 09:51:05', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(7, 'cus_IvSnRdihhvupRI', 'oliver', 'abcd', 'abc', 'UK', 'abc@abc.com', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 09:53:59', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(8, 'cus_IvStBf5P5ahTND', 'oliver', 'abcd', 'abc', 'UK', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 09:59:42', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(9, 'cus_IvTV7TnF1cYCdc', 'oliver', 'abcd', 'abc', 'UK', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 10:38:16', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(10, 'cus_IvVlOo6FitZpEx', 'oliver', 'abcd', 'abc', 'UK', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', '-AU-QLD', 'MYPAYMENT', '2021-02-11 12:57:59', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(11, 'cus_IvWtZ94EepgFyD', 'oliver', 'abcd', 'abc', 'United Kingdom', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', 'Barnsley', 'MYPAYMENT', '2021-02-11 14:07:52', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(12, 'cus_IvXNLwKDhR69ny', 'oliver', 'abcd', 'abc', 'United Kingdom', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', 'Barking and Dagenham', 'MYPAYMENT', '2021-02-11 14:37:26', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(13, 'cus_IvXPcqwUe9cMgt', 'oliver', 'abcd', 'abc', 'United Kingdom', 'abc@abc.com', '', '', '', 'abc', 'xyz', 'Barking and Dagenham', 'MYPAYMENT', '2021-02-11 14:40:23', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(14, 'cus_IvXqb9Ki5yLYjf', 'oliver', 'abcd', 'abc', 'United Kingdom', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', 'Barnsley', 'MYPAYMENT', '2021-02-11 15:06:58', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(15, 'cus_IvXskEwRtnamM5', 'Jamal', 'House no : R-1 Crystal Homes BLK 19 Gulistan-e-Johar Near opp to Gulshan Banglows', 'Karachi', 'Pakistan', 'jamal.ahmed85@hotmail.com', '', '', '', 'Jamal', 'Ahmed', 'Sindh', 'MYPAYMENT', '2021-02-11 15:09:16', '', '7538', 'Jamal Ahmed', 'Stripe', '', NULL, NULL, 0),
(16, 'cus_IvYnlEYf4ouySv', 'Umair Hussain', 'Akhter Colony', 'Karachi', 'Pakistan', 'umairshaikh.tk@gmail.com', '', '', '', 'Umair', 'Zulfiqar', 'Sindh', 'b2beh', '2021-02-11 16:06:24', '', '9275', 'Umair Zulfiqar', 'Stripe', '', NULL, NULL, 0),
(17, 'cus_IvYqJTl8eSggeX', 'Umair Hussain', 'Akhter Colony', 'Karachi', 'Pakistan', 'umairshaikh.tk@gmail.com', '', '', '', 'Umair', 'Zulfiqar', 'Sindh', 'b2btk', '2021-02-11 16:08:54', '', '9275', 'Umair Zulfiqar', 'Stripe', '', NULL, NULL, 0),
(18, 'cus_IvYxvK1k7jtadX', 'oliver', 'abcd', 'abc', 'United Kingdom', 'hafiz.zeeshan@technado.co', '', '', '', 'abc', 'xyz', 'Bath and North East Somerset', 'L-IWS', '2021-02-11 16:15:39', '', '4242', 'abc xyz', 'Stripe', '', NULL, NULL, 0),
(19, 'cus_IvZ2JRN0YFIbEX', 'Jamal', 'House no : R-1 Crystal Homes BLK 19 Gulistan-e-Johar Near opp to Gulshan Banglows', 'Karachi', 'Pakistan', 'jamal.ahmed85@hotmail.com', '', '', '', 'Jamal', 'Ahmed', 'Sindh', 'L-MNS', '2021-02-11 16:20:35', '', '7538', 'Jamal Ahmed', 'Stripe', '', NULL, NULL, 0);

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `sales` varchar(200) NOT NULL,
  `amount` double(18,2) NOT NULL,
  `currency` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `statement` varchar(200) NOT NULL,
  `transaction_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
