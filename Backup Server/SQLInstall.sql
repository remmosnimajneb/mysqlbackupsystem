--********************************
--* Project: Web Server Backup System
--* Code Version: 1.0
--* Author: Benjamin Sommer
--* GitHub: https://github.com/remmosnimajneb
--* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
--* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
--***************************************************************************************/

CREATE DATABASE IF NOT EXISTS `mysqlbackups` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mysqlbackups`;

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

CREATE TABLE `websites` (
  `WebsiteID` int(9) NOT NULL,
  `domainName` varchar(120) NOT NULL,
  `databaseName` varchar(120) DEFAULT NULL,
  `filePath` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indexes for table `websites`
--
ALTER TABLE `websites`
  ADD PRIMARY KEY (`WebsiteID`);

--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `WebsiteID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
