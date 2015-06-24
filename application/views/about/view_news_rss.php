<? echo '<?xml version="1.0" encoding="utf-8"?>' . "\n"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:admin="http://webns.net/mvcb/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/assets/">
	<channel>
		<title><?=$feed_name?></title>
		<link><?=$feed_url?></link>
		<description><?=$page_description?></description>
		<dc:language><?=$page_language?></dc:language>
		<dc:creator><?=$creator_email?></dc:creator>

		<dc:rights>Copyright <? echo gmdate("Y", time());?></dc:rights>
		<admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />

		<? foreach($posts as $entry): ?>
			<item>
				<title><? echo xml_convert(date("jS F, Y", $entry['unix_time'])); ?></title>
				<link><? echo base_url() ?></link>
				<guid><? echo base_url() . $entry['unix_time']; ?></guid>

				<description><![CDATA[
				<?=str_replace("\n", "<br/>", $entry['entry'])?>
				]]></description>
				<pubDate>
					<? echo date ('r', $entry['unix_time']);?>
					</pubDate>
			</item>
		<? endforeach; ?>

	</channel>
</rss>  