<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url(); ?></loc> 
        <priority>1.0</priority>
    </url>
    <?php foreach ($data as $value) {
    ?>
    <url>
        <loc><?= base_url().$value['loc'] ?></loc>
        <changefreq><?=$value['changefreq']?></changefreq>
        <priority><?=$value['priority']?></priority>
    </url>
    <?php 
} ?>

</urlset>