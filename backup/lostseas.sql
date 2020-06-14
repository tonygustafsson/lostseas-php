-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Värd: db
-- Tid vid skapande: 14 jun 2020 kl 09:42
-- Serverversion: 8.0.20
-- PHP-version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `lostseas`
--

CREATE DATABASE lostseas;
USE lostseas;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_crew`
--

CREATE TABLE `ls_crew` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL DEFAULT '0',
  `nationality` varchar(15) DEFAULT NULL,
  `gender` varchar(1) NOT NULL,
  `created` int NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `doubloons` int NOT NULL DEFAULT '0',
  `mood` tinyint NOT NULL DEFAULT '10',
  `health` tinyint NOT NULL DEFAULT '100',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_game`
--

CREATE TABLE `ls_game` (
  `user_id` varchar(20) NOT NULL DEFAULT '0',
  `character_name` varchar(50) NOT NULL,
  `character_avatar` tinyint NOT NULL DEFAULT '1',
  `character_gender` varchar(1) NOT NULL,
  `character_age` tinyint NOT NULL DEFAULT '0',
  `character_description` text,
  `nationality` varchar(20) NOT NULL DEFAULT '0',
  `town` varchar(20) NOT NULL,
  `place` varchar(20) NOT NULL,
  `week` int NOT NULL DEFAULT '1',
  `title` varchar(20) NOT NULL,
  `doubloons` int NOT NULL DEFAULT '300',
  `bank_account` int NOT NULL DEFAULT '0',
  `bank_loan` int NOT NULL DEFAULT '0',
  `cannons` int NOT NULL DEFAULT '2',
  `prisoners` int NOT NULL DEFAULT '0',
  `food` int NOT NULL DEFAULT '20',
  `water` int NOT NULL DEFAULT '40',
  `porcelain` int NOT NULL DEFAULT '0',
  `spices` int NOT NULL DEFAULT '0',
  `silk` int NOT NULL DEFAULT '0',
  `tobacco` int NOT NULL DEFAULT '0',
  `rum` int NOT NULL DEFAULT '0',
  `medicine` int NOT NULL DEFAULT '0',
  `rafts` int NOT NULL DEFAULT '1',
  `victories_england` int NOT NULL DEFAULT '0',
  `victories_france` int NOT NULL DEFAULT '0',
  `victories_spain` int NOT NULL DEFAULT '0',
  `victories_holland` int NOT NULL DEFAULT '0',
  `victories_pirates` int NOT NULL DEFAULT '0',
  `event_market_goods` varchar(128) DEFAULT NULL,
  `event_market_slaves` varchar(128) DEFAULT NULL,
  `event_sailors` varchar(128) DEFAULT NULL,
  `event_work` varchar(128) DEFAULT NULL,
  `event_ship` varchar(128) DEFAULT NULL,
  `event_ship_won` varchar(256) DEFAULT NULL,
  `event_ocean_trade` varchar(128) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_history`
--

CREATE TABLE `ls_history` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `week` int NOT NULL,
  `doubloons` int NOT NULL,
  `ships` int NOT NULL,
  `crew_members` int NOT NULL,
  `crew_mood` int NOT NULL,
  `crew_health` int NOT NULL,
  `cannons` int NOT NULL,
  `stock_value` int NOT NULL,
  `level` int NOT NULL,
  `victories` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_log`
--

CREATE TABLE `ls_log` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `time` datetime NOT NULL,
  `week` int NOT NULL,
  `entry` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_news`
--

CREATE TABLE `ls_news` (
  `id` int NOT NULL,
  `time` datetime NOT NULL,
  `entry` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `ls_news`
--

INSERT INTO `ls_news` (`id`, `time`, `entry`) VALUES
(1, '2010-10-24 00:00:00', 'A chat is now implemented and is opened in a new window.\n\nA log book is now recording your every move in this game, so that you can go back in time and see what has been done.'),
(3, '2010-10-28 00:00:00', 'You can now buy food and drinks at the tavern. It will make your crew happier!\n\nYou can gamble in the tavern! Better chance than reality, but you will still probably loose :P\n\nYou can talk to the sailors at the tavern. Sometimes they will attack you, but mostly they might want to join your crew.'),
(7, '2010-11-10 00:00:00', 'The bank is finished! You can put in or take out of your account, and loan money.\n\nThere is a lot of new nice looking icons in the game.\n\nThe streets are replaces by the dock. Seemed more logical. There\'s nothing to do in the streets anyways. It\'s just a place where you arrive when you land your ship.\n\nHospital is removed, some of it\'s functions are transfered to Temple instead.'),
(8, '2010-11-13 00:00:00', 'The shipyard is done! I had to define which ship types that exists. You can now buy and sell them here. Also you can buy cannons and life boats. Ship repairing is implemented too.'),
(9, '2010-11-14 00:00:00', 'The market is done! You can browse for goods and slaves. The offer you receive will be random in quantity and price. Slaves will become your crew members. Only one visit per town visit!'),
(10, '2010-11-17 00:00:00', 'The city hall is done! I\'ve implemented the title system. The governor will reward you if you fight their enemies. If the governor is not from your nation, he will offer you citizenship if your good. Once your a citizen, you will get promoted and get rewards.\n\nYou can work in the city hall and make money. One time per town visit. The downside of this is that your crew don\'t like working, so they get less happy.\n\nYou can leave your prisoners if you have any, in the city hall. You will get a random reward.'),
(11, '2010-11-18 00:00:00', 'Removed the temple. I felt that gods, magic, mana and stuff didn\'t feel right in a game like this. I want this game to have a sense of reality, maybe more so than other pirate games. I still want players to be able to heal their crew, so I created a healer at the market, and the shop will sell medicine soon.\n\nCreated this About section of the page. I commented news in the chat before but there was not that much space. Now I can tell you more stuff that I\'m doing.\n\nRemoved the chat to the right and replaced it with the towns location instead. It was annoying to have to reach this menu at bottom of every page. At sea this menu will only let you dock at the nearest town.\n\nThe chat will work again soon, but it will then open in a new window instead. Not everyone wants to chat, and it nice to have this in a separate window I think.\n\nFixed some bugs that made it possible to go to a towns location from the sea, and to change the town without leaving the town.'),
(12, '2010-11-19 00:00:00', 'The chat function is back in bussiness! It looks really good I think, and works so much better than before. It updates every 20 seconds, or when you say something.\n'),
(13, '2010-11-20 00:00:00', 'You can heal your men at the markets healer. If your crew is 60% healthy, she will only charge you for the 40%. When you\'ll give your crew medicine, they will always need a bottle each.\n\nYou can discard your crew members now. You just check the crew members you don\'t need anymore, choose \'Discard crew members\' at the list at the bottom, and click \'Do it!\'.'),
(14, '2010-11-21 00:00:00', 'You can now buy and sell things at the shop in one step. No need for separate buy and sell pages.\n\nYou can buy medicine at the shop.\n\nYou can give your crew members medicine. Later you will be able to give them tobacco and rum also.\n'),
(15, '2010-11-24 00:00:00', 'There is a nice map to click on when you\'re at sea! I\'ve changed some towns that you can access in the game. The map is from the year 1697 and is accurate. I\'m not totally sure if Bonaire where owned by the Dutch at that year, but I think so. The map uses image map combined with javascript. Beautiful I think! :)\n\nThe text in the inventory has been replaced by icons. Looks kind of nice.'),
(16, '2010-11-26 00:00:00', 'The coast is replaced by the harbor. Seemed more correct.\n\nYou cannot access the dock from the menu, but you will still end up there if you land your ship at a town. There is nothing to do there, and I don\'t think there will be either...\n\nThis about page is now accessible for users who is not logged in.'),
(17, '2010-11-29 00:00:00', 'Wrote some questions and answers at the FAQ.\n\nMade some basic code more efficient.\n\nA warning at the start page if your don\'t use Firefox. This will change in the future though.\n\nStill working on the sea battles. You CAN meet ships now, but you cannot do much more than ignore and flee.'),
(18, '2010-12-02 00:00:00', 'The authentication method has been rewritten because of security holes.\n\nYou can now unregister from Dark Seas!\n\nLots of bugs has been corrected about registration, login, settings and such.\n'),
(19, '2010-12-03 00:00:00', 'Dark Seas now works with no problem in Firefox, Chrome and Opera. Safari does work, but audio won\'t. Internet Explorer 8 seems to have some trouble with some basic javascript functionality, doesn\'t play audio, and renders some design elements ugly. The warning page at the front page has been updated.\n\nLife boats are replaced by rafts, and does show up at the inventory to the left.\n\nYou start with one raft when you register, and the price has dropped by 50 %. One raft will only save 10 crew members.\n\nSome bugs were fixed at the shipyard.'),
(20, '2010-12-06 00:00:00', 'I\'ve filled the page About > Ideas and made it possible to send in suggestions.\n\nNew icons for the Settings menu, and trimmed the code some.'),
(21, '2010-12-10 00:00:00', 'Fixed some stuff in the background. Like how Javascript handles errors. The experience is faster now than before. Some design bugs. Moved a lot of PHP code, more intuitive now.\n\nThe game only gets one AJAX calls when you change your location instead of two or three!\n\nThe places to the right only updates when necessary. Faster!\n\nFixed a bug at the chat. Now the last 30 rows are displayed, and nothing is erased from the database. Also, you cannot write HTML code in the chat anymore.'),
(22, '2010-12-11 00:00:00', 'Finally! You can fight ships at sea! It has taken a lot of time to implement, and there are still much to do. More things will happen at sea very soon.\n\nYou can now reset the game if you go to Settings > Character. Check the checkbox and you can start over if you get stuck. Sometimes there is no turning back!\n\nI separated the user info from the character info at the Player menu. I also made a link to a gustbook that\'s not implemented yet.'),
(23, '2010-12-13 00:00:00', 'The guestbook is in place. You will get emailed if you receive a guestbook message, and you can control this behavior if you log in and click Settings > User. You will always get an icon in the inventory when you get new messages. You cannot delete messages yet...\n\nYou know those privacy settings that let you control what people see about you? Well, now they actually work :P\n\nI made a clean up of the code that gets user info from the database, and the Players menu now uses much of it\'s code. This made it easier to add more info about players. You can now see number of ships, crew members, title and much more.'),
(24, '2010-12-14 00:00:00', 'The HTML title now changes when you click on a link in the game. Due to AJAX calls, this did not update automatically before. Now you will see where you are in your browser title bar.\n\nMoved all database functions to one place a la MVC, and renamed the database tables. This makes it very easy for me to rename them in the future if I need to. This will be necessary for the future when there will be a prod and test version of this game.'),
(27, '2010-12-15 00:00:00', 'This news page is now dynamic. Administrators (=me) can now add news from a form. This also means that pagination is possible... the page began to get kind of big.\n\nRemoved Log book from the top menu, but it\'s still available in the inventory. Didn\'t see why this part should take up such a big place. Also worked on the log book design a bit.\n\nYou can now see other players log books in Players > [User] > Log book. If you don\'t want to show others your log book your can deselect this feature in Settings > Account.'),
(28, '2010-12-16 00:00:00', 'The log book now supports pagination, so that the page don\'t get that long anymore. Fixed some log book bugs.\n\nYou can now give your crew members tobacco and rum that you bought at the shop. Go to Inventory > Crew and check the members you want to make happier and choose \"give tobacco\" or \"give rum\".\n\nSome descriptions about stuff you can buy at towns. Even some new nice looking icons for every grocery. :)\n\nI was experimenting some with random greeting messages when you arrive at new places in the game. It\'s far from done, but It\'s on piece closer to a more \"living\", dynamic game. Take the shop for example, the merchant says different things every time, he even changes what he says depending on your age and gender!'),
(29, '2010-12-17 00:00:00', 'Your crew now gets angrier for every week that passes at sea! If one or more of your crew is \"angry\" (mood less or equal -10) they will refuse to travel any longer. If your in a town, they won\'t leave it until they are pleased.\n\nThere are a number of things you can only do once per town visit. These were resetted when you leaved the town to the harbor before. Now they are resetted first when you reach the ocean.\n\nI noticed that the new greeting system was buggy, for example when you took action somewhere, the greeting would be missing. I had to rethink how this would work which made me do more and more globally and with autoloading function instead of adding more code to each location/file. I think I deleted over 100 lines of code because of this :)'),
(30, '2010-12-18 00:00:00', 'The crews mood will increase by 3 if they win a battle at sea!\n\nFixed some thing at the inventory, such as links to the bank from the money-page and more information about how to change things.\n\nFixed bugs in sea battle and checks that are made to being able to depart from land.'),
(31, '2010-12-20 00:00:00', 'You can now encounter ships when you travel from the Caribbean Sea to a harbor too. Fixed a lot of ocean related bugs.\n\nThere is now one chance in four that you do not succeed in fleeing from ship. The fight will then go on as an ordinary attack, which means that you could be killed anyway.'),
(32, '2010-12-21 00:00:00', 'You will have to verify your account via email when you register a new account. I wanted to avoid this because visitors are lazy by nature - but It\'s not OK to register with someone else\'s email address. When you register you will be taken to the FAQ page that gives you more information about how to play.'),
(33, '2010-12-23 00:00:00', 'The front page is remade! I put the login to the left, and made a separate page for registration. This made it possible to have a nice presentation at the front page. Also changed some icons and fixed a few bugs.\n\nMore beautiful icons at the shop and inventory pages.\n\nFixed a bug at the shop, tavern and shipyard that made it possible to sell more than you\'ve got.\n\nDid some web standardisation. The front page now validates as valid HTML5. The Javascript is cleaned up a bit too.\n\nApparently the game didn\'t register victories over ships, so the governor could not promote you. If you win a battle over a ship from Spain, you will now see this in the inventory.\n\nFixed some bugs at the market. The game didn\'t ban you from the goods or slaves if you didn\'t have any money. And the healer healed so great that she left you with less than zero dublones if you didn\'t have enough.\n\nAdded 6 new songs from Zelda - Wind Waker :) Now there is 23 songs total.'),
(36, '2010-12-24 00:00:00', 'It\'s now possible to answer and erase guestbook entries. Was not that easy because I put the name of the poster instead of the ID. It\'s now fixed...'),
(37, '2010-12-25 00:00:00', 'You can now see mood and health directly in the inventory! The icons will change dependent on your crew members lowest health and mood. I love it! :)\n\nIf you meet a ship at a harbor it\'s now 50% chance that he is from the same nation as the town it\'s close to. It was hard to find the right ships to fight.\n\nFood and water is now really need to keep on traveling the ocean. 1 food carton per crew member and week, and 2 for water. You will see it go down live in the inventory while you exploring.\n\nThe governor no longer thanks \"for the 0 enemy ships you sunken\", instead he just encourage you to attack them. And he will not be pleased if you have sunken more ships from your own nation than your enemy. He won\'t do anything about it though, not getting promoted is bad enough.\n\nThe game now remembers what you choose in the crew inventory. The checked crew and action is saved so that you can just keep clicking to do it more times than once. Also, you won\'t see actions you cannot perform. Like \"Give medicine\" if you do not own any medicine boxes.\n\nFixed a bug that showed an empty page instead of the sailors wanting to join your crew.\n\nYou can now longer post empty guestbook or chat entries.'),
(38, '2011-01-03 00:00:00', 'Rewrote the code for changing the crew members health. They can now be killed if their health is less than 1 %. Better code.\n\nYou now start of with 4 crew members instead of 2. You will need two crew per cannon to make it useful, so it seemed right. This made me double the amount of food and water you start with.'),
(39, '2011-01-04 00:00:00', 'Your crew now gets 50 % of what you loot at sea or in tavern. Your share is not lowered though. Their loot is divided equally between them, so if you get 100 dbl and have 4 crew members, they will get 50 dbl, and 50/4=12 dbl each. No purpose with crew money yet, but it\'s a way to see who has been to most value to you.'),
(40, '2011-01-05 00:00:00', 'New icons for bank account and bank loans in the inventory and bank.\n\nFixed some bugs here and there.'),
(41, '2011-01-07 00:00:00', 'Fixed a long lasting bug that often made the sliders at the shop, tavern, bank and such to not display. I also made the code for this better, so that it\'s faster and Opera didn\'t have any problem with it.\n\n\"Ignore\" is now the first choice when you meet a ship from your own nation, instead of \"Attack\". When you meet enemy ships, it will say so.\n\nYou now see how many useful cannons you\'ve got at the inventory. If you own 9 crew members, and every cannon needs 2 members to be useful, you will then get 4 useful cannons no matter how many cannons you actually got. It was boring to calculate this every time you wanted to attack a ship.\n\nFixed a bug at the tavern. When you bought food and drinks you only paid for yourself. Now you have to pay for the whole crew, which makes things a lot more expensive!\n\nYou can now find things at the market that is more expensive than in the store. Why? Before you didn\'t need to think about it, just click \"Yes\" and sell it of at the store. Now it is between 50-110% of the cost in the store.'),
(42, '2011-01-08 00:00:00', 'You can now capture prisoners from enemy ships and pirate ships. You can hand them over at the City Hall for a ransom. Now you can only hand them in at your home nation, and the ransom is 300-1000 dbl (lowered a bit).\n\nThe buttons to attack, ignore and flee ships are now changed a bit. The recommended one is yellow, the other one is white. I found myself clicking attack when I wanted to ignore, and I died a couple of times because of this :P'),
(43, '2011-01-09 00:00:00', 'When you arrive at the docks from the harbor, you will now see a list of things you should to before you take off again. It estimates that you want to travel for 5 more weeks the next time, and tell you what you need to buy, sell, and fix.\n\nThe shop will now also tell you how much more food and water you need for 5 more weeks at sea.'),
(44, '2011-01-10 00:00:00', 'If you loose in battle you will still loose all your money, but you will only loose parts of your goods. If you have three ships, you will loose a third of your food, water, porcelain, spices, silk, medicine, tobacco and rum.\n\nYou will find less barter goods to loot in sea battle than before. Sometimes you would get ridiculous amounts of rum for example that made you kind of rich easily.\n\nThe crew now needs just half the food and water per week. It was annoying to buy 200 barrels of water every time you visited a new town.'),
(45, '2011-01-11 00:00:00', 'The game has reached public beta stage!! :D\n\nMade some changes regarding win/lose ratio in sea battles. It\'s a bit easier now...\n\nCreated a test version of this game, for future code changes. I would like this game to be stable enough now to let people try it out. :)\n\nIt was possible to have an endless amount of crew members and still go to harbor before; fixed!'),
(46, '2011-05-02 00:00:00', 'Upgraded to the latest version of CodeIgniter and jQuery. The first one took some time because some of the code structure was remade. The application directory is not inside system anymore, which is good when It comes to upgrading in the future. But it took me some time to get the code right.\n\nAll models (database communication functions) are remade and separated from one class to one per database. Some code from Controllers were moved to the Models instead. Instead of using a lot of cryptic method names, they are now standardized. Like $this->User->get() or $this->Ship->erase(). All models have get(), update(), create() and erase()... that’s it!\n\nTurned on output compression, which I hope will speed up loading time for visitors. This created some problem, like not being able to echo things directly, so everything now goes through a View like it always should be in a MVC application.\n\nCombined some javascript and stylesheet files, and minified some of them, which also will make things a bit faster. I won’t minify code that needs to be maintained, It would be a mess. But things like the stylesheet for jQuery UI is awesome to minify and combine with my own custom.css.\n\nPlayed around a bit with AJAX and JSON and implemented a better POST function for About > News. I will develop this a bit more and replace more and more with JSON functions in the future to speed it up even more!\n\nRemoved the need for index.php in the URLs. Nicer looking!\n\nMade some HTTP headers that make browsers happy. Mostly about cache. Images, Javascript and Stylesheets is now cached for a month by default. This, and many more fixes took Dark Seas from 79 points to 94 points at Googles Page Speed Test.\n\nDark Seas is now verified in Internet Explorer 9, and it is now officially supported. The front page will only warn if you are using IE8 or below. It will still warn about Safaris audio support, but not for Chrome anymore.\n\nSolved the bug that just returned blank pages when you were logged out. Now you will be redirected to the start page.\n\nThe Chat is renamed to Parley, mostly for technical reasons.\n\nFixed a bug that made it possible to travel from town to town and not waste food or water.\nAbout > Tech was created. I wanted to show people what technologies are behind Dark Seas, what they mean, and inform them about why old browsers won’t work.\nRewritten the way we change town in the game, less and better code.\n\nA little piraty favicon was added.\n\nA lot of other stuff has happened. Not much game features though...'),
(47, '2011-05-24 00:00:00', 'The shopping experience has been greatly improved! The design is nicer, but mostly the usability is much much better. Instead of seeing how much you buy when you drag the sliders, you will see how much you will end up having if the trade is accepted. You will always see how many doubloons you have left, so that you don\'t have to scroll to the bottom of the page all the time to find out if you can afford it or not. The validation code is better, and the need for JavaScript validation was gone. At the shop you will find new buttons that let you sell all barter goods at once, and buy all you need for traveling for 5 more weeks. Wow, I wonder how I survived without it!\n\nI have rewritten the attack script that you are using at sea. For the first time, I\'m no longer scared of going in to that code :D It was a mess, and now It\'s nice! The code is also smaller, more efficient and fixed a couple of long lasting bugs. Like when you tried to flee from a ship and failed, you would only see the result of the fight, leaving you wondering what the fuck happened.\n\nAfter a sea fight you will see a nicer looking list of good and bad things that happened through the fight. Like things you looted, if a ship broke due to ship damaged, if someone in your crew died, if they took anything from you, and such.\n\nShip damages is implemented! You ships will be damaged in battle, and more so if your lose the battle. You can repair your ships at the shipyard. It their health is less than 1 % it will break. Just as your crew member will die under 1 %. You can always see your ships health in the inventory.\n\nThe crew member list at the inventory has been improved. You can sort the list by clicking on the table topics, both asc and desc. The little action menus will be shown both at the top and bottom if the number of crew member is over 25 (so you don\'t have to scroll that much). You can also select crew members by clicking anywhere on the row, not just the little checkbox. Selected members is highlighted. This is great! This means that you could sort them by health and discard the members that is bringing the total health down. Or sort them after mood and give rum the ones that need  it the most.\n\nMusic for everyone! This game now supports both OGG and AAC, which means that the music now works in Internet Explorer 9 and Safari. The scripts has been improved quite a lot. You will now find the music controls at the top menu instead of under the Inventory (not a very logical place). And you will see a button that skips the current song and plays a new, random, piraty song. 10 more tracks has been added!\n\nThe docks will now show more things that you should do before you leave the town again. Like visit the governor if he would like to speak to you. I don\'t know about you, but I often forgot to check for new titles at the City Hall. The todo list has also been redesigned, with images! Oh so pretty <3\n\nYou can no longer loot more goods than the ship can carry. It was a bit easier before, when you just could loot 1000 barrels of rum and sell it for a\nsmall fortune.\n\nI have added a random character generator at the registration and character settings. It fetches a random name from a list of a thousand names through AJAX, and sometimes combines them. It also selects a random age and gender. Visitors really hate doing more work than they have to :P\n\nYou will get to the action menus directly when you visit a towns different places. For example you can buy cannons without clicking on Fixings at the shipyard. And you can buy your crew some rum directly when you click on the tavern. I tried to see what people mostly wanted to do when they visited to avoid unnecessary clicking / waiting.\n\nDark Seas now has a RSS feed for it\'s news page. So if anyone would like to know when something in the game is changed, please subscribe. This is nice because I won\'t have to promote the site when It changes. Those who cares will know...\n\nTweaked the design a little. The buttons are more beautiful, and the images has a nice, round border. A lot of smaller fixes here and there.\n\nUpgraded to the latest version of jQuery and jQuery UI. Removed parts of UI that wasn\'t used. 34 kb saved!\n\nYou will now be logged in for twelve hours instead of one if you don\'t log out. The main reason for this was solving an issue in Explorer and Safari which logged them out after a couple of seconds. The server is two hour behind so the browser thought the time had passed.'),
(48, '2011-05-26 00:00:00', 'I redefined the levels and titles in the game, and documented it at About > FAQ. Now you can see what you can become for the first time. The rewards for getting a new title has been increased radically. Fixed a bug that made it possible to be \"promoted\" when you fight your own nations ships and decreased in rank. You still won\'t be demoted when you do so though.\n\nI thought I had a limit of maximum 10 ships in this game, but apperently I did not :) My friend who played this game for a while had 99 ships after a while, 4500 crew members and over a million doubloons. With no ship limit there is no crew member limit, and there by no limitations at all. Now the maximum number of ships is regulated by your rank. As a pirate (as you start of) you can only own 3 ships. The total maximum is 15 ships as a duke, and there by 1500 crew members. Which is A LOT.\n\nThe character will now age as you play. 1 years older if you play for 52 game weeks.'),
(49, '2011-07-17 00:00:00', 'The event system has been rewritten. You can now click around in the game without loosing data/events. If, for example, some sailors offers to join you, they will still join you if you visit the shop first. This also solved some bugs and make new features possible.\n\nWhen you win a battle at sea, you can choose how much you want to loot. Sometimes you cannot handle more crew members, or you\'ll be angry that you couldn\'t prioritize water instead of porcelain. Now that problem is solved! This is one step forward towards a more interactive game.\n\nYou can now trade with your allies at sea. You will trade away barter goods for useful goods (food and water). Which means you can stay longer at the sea. You choose how much you want with sliders, and you will only pay as much as you need with your barter goods. It will trade away useless things first, and later medicine, tobacco and rum. Unfortunately the code doesn\'t know how much barter goods that will be needed for the transaction so it won\'t be subtracted from the total load, which means that you cannot load your ship too 100 % with this.\n\nYou can now see much more about the other players. It uses the same function that you use for your own inventory. This made it possible to merge players.php with inventory.php. Less code, more features.\n\nDesign changes! A nice new top menu, the background is replaced and fixed some minor stuff. When the game is loading, it will say so very noticably. Some SEO fixes.\n\nA new Guide that will help players along in the game. It\'s also for show off for visitors who\'s not registered yet. Why would anyone register who don\'t know what\'s inside the game?\n\nThe places menu at the right does not update with AJAX anymore which make much fewer HTTP requests. Which means faster game experience and no bugs. Sometimes the places menu were wrong before...\n\nIt\'s now easier to find new ships, and it\'s easier to win the battles. The ship you meet will be created after how many useful cannons you have instead of how many crew members you\'ve got. Often you have more crew members than useful cannons.\n\nYou will now see different flags on the ships you meet so that you can easily know what you are up against without having to read the description.\n\nA copyright section of the page that you can access by clicking the footer. It felt like a link but wasn\'t. Now it is...\n\nSolved a lot of small bugs. Also fixed the dumb bug regarding the City Halls governor that got an error if your level was 0, which it is when you start out.'),
(50, '2013-05-04 00:00:00', 'This game now has It\'s own domain name: lostseas.com! The game is renamed from \"Dark Seas!\" to \"Lost Seas\" because of that.\n\nYou no longer have to register to play this game; Just press \"Play!\" and you can begin immediately. You still have to register to save your session and to interact with other players.\n\nThe game now uses HTML5 pushState to change the URL address depending on what you are doing. Now you can use your browsers back and forward buttons to go between the tavern and the docks ;) An even better feature is that Google now can crawl this site.\n\nA lot of more AJAX! Forms and many links now returns JSON instead of HTML code. The inventory, and many more fields, can now update only the changed items instead of the whole inventory.\n\nA new, brighter and more responsive web design.The position of the inventory and \"action panel\" has been changed. You will now find the inventory to the left, and it\'s a lot more beautiful and responsive. It\'s now possible to play this game on a mobile device - the menus will then collapse into menu buttons instead. Also Google Pagespeed says 93/100 instead of 84/100 :)\n\nThe nations now has different images to represent the different places, like shop, bank and so on. So it will look different in Panama than in Biloxi for example.\n\nGuestbook has been renamed to \"Messages\". Parley is renamed to Chat.\n\nThe latest jQuery 2.0 and CodeIgniter. No more support for Internet Explorer 8.\n\nGoogle Analytics will help me to better understand the gamers, how they think, what they do. Anonymously of course.\n\nA \"God mode\" has been created that lets admins change almost everything in the game (cheating!). For now it\'s for bug testing - in the future it will be for fixing problems for users.\n\nA LOT of bug fixes. And probably some new onces. This is a huge update, and actually most of the code is rewritten. Two years since the last update - i know :)'),
(51, '2013-09-08 00:00:00', 'Every week that passes will now record history data, such as doubloons, victories, crew mood etc. This data can then be viewed as graphs under your user and the History button. The point of this is to make it easier to keep track of your gaming. The graph is using Flot Charts for plotting the data. \"User\" and \"Status\" has merged in to \"Player\" to make room.\n\nOne more step that has led to a better understanding of the game history is the new logging function, with clearer messages and that logs a bit more. Your logs is now categorized by week instead for a better overview. Also you can see what\'s going on in the game at the start page (privacy settings control whether or not your game playing is displayed here or not).\n\nSound effects are implemented for many things. Adds to the atmosphere of the game. Like coins falling when you make a transaction. This can of course be turned off, in the new Sound Control, that controls both the music and sound effects. Volume control is also implemented, and is remembered from visit to visit. Also a better music player, no more ugly html code, no ugly body tag hack. Four new songs has been added, and two were deleted.\n\nProfile pictures are now activated. They are shown in the Players menu and in the chat. The upload is HTML5 + AJAX of course.\n\nAvatars for characters is in place! Awesome! Already at the start page you can choose between 80 avatars. This can be changed under Settings whenever you want. The gender of the character is decided when your avatar is chosen. Your avatar is shown under Players, in the Inventory and the log panel at the start page.\n\nThe shop has changed. Many gamers felt like it was a confusion story making transactions here. Now the sliders are horizontal instead, making them fit on one screen so that you won\'t have to scroll a lot. Instead of seeing how much money you will have <em>after</em> the transaction, you will see the cost. Hover the products to get more information about what they are and what they are needed for.\n\nThe buying experience at the tavern has changed. Instead of sliders, you\'ll only get buttons that increase the crews health and mood. It\'s the same basics, but with less confusion. Wenches is back! Hurray! They increase some crew health, but mostly mood. :)\n\nGalleons are no longer a trading ship but a war ship. The Merchantman has taken it\'s place instead. The Frigate has taken the Carracks place. To be clear; the brig is unchanged, the Merchantman is for trading / loading boxes, the Galleon is a war ship, and the Frigate is the biggest, most fearsome war ship out there.\n\nThe game keeps track of the players real activity. If you have this tab open, the game will know about it. Online gamers are displayed in green at Players. The chat now shows these players in a panel, and the chat is much better looking, with profile pictures. Fixed a cache bug in IE10 that made the chat invisible.\n\nNew messages from other users will appear without page load from now on. In the inventory as usual...\n\nBetter Godmode (admin \"cheat\" area). Ability to change newly created objects, live updating the inventory, quick buttons for changing values for all crew members / ships. Ability to change the User table. Ability to change all users settings, not just my own. Before you ask, this is mainly used to try out new features and bug testing. Now I can also fix other players problem if they would occur.\n\nAt your inventory you can now give your crew members doubloons, which increases their mood.\n\nSmall things, like anchor links working through AJAX, better logged out messages that won\'t confusing you into thinking that the game is broken. Fixing some spelling errors, and just trying my best to clearify some things for the players. Probably 40+ bugs were fixed.\n\nThe JavaScripts had a face lift. I ran it through JSLint and got scared. But the result is much better code, that hopefully works fine in all modern browsers.\n\nUpgraded CodeIgniter and jQuery.');

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_ship`
--

CREATE TABLE `ls_ship` (
  `id` int NOT NULL,
  `user_id` varchar(20) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL,
  `age` int NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `health` tinyint NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellstruktur `ls_user`
--

CREATE TABLE `ls_user` (
  `id` varchar(20) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(40) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `new_email` varchar(50) DEFAULT NULL,
  `presentation` text,
  `music_play` tinyint(1) NOT NULL DEFAULT '1',
  `music_volume` tinyint NOT NULL DEFAULT '100',
  `sound_effects_play` tinyint(1) NOT NULL DEFAULT '1',
  `show_gender` tinyint(1) NOT NULL DEFAULT '1',
  `show_age` tinyint(1) NOT NULL DEFAULT '1',
  `show_email` tinyint(1) NOT NULL DEFAULT '1',
  `show_history` tinyint(1) NOT NULL DEFAULT '1',
  `notify_new_messages` tinyint(1) NOT NULL DEFAULT '1',
  `new_messages` tinyint NOT NULL DEFAULT '0',
  `password_pin` varchar(32) DEFAULT NULL,
  `email_pin` varchar(32) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `ls_crew`
--
ALTER TABLE `ls_crew`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_game`
--
ALTER TABLE `ls_game`
  ADD PRIMARY KEY (`user_id`);

--
-- Index för tabell `ls_history`
--
ALTER TABLE `ls_history`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_log`
--
ALTER TABLE `ls_log`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_news`
--
ALTER TABLE `ls_news`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_ship`
--
ALTER TABLE `ls_ship`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `ls_user`
--
ALTER TABLE `ls_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `ls_crew`
--
ALTER TABLE `ls_crew`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4764;

--
-- AUTO_INCREMENT för tabell `ls_history`
--
ALTER TABLE `ls_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3783;

--
-- AUTO_INCREMENT för tabell `ls_log`
--
ALTER TABLE `ls_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11301;

--
-- AUTO_INCREMENT för tabell `ls_news`
--
ALTER TABLE `ls_news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT för tabell `ls_ship`
--
ALTER TABLE `ls_ship`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=805;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
