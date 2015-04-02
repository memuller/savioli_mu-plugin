UPDATE mz_site SET domain = 'clinicasavioli.com.br' ;
UPDATE mz_blogs SET domain = REPLACE(domain, 'dev.gioli.com.br', 'clinicasavioli.com.br');



UPDATE mz_options SET option_value = REPLACE(option_value, 'dev.gioli.com.br', 'clinicasavioli.com.br') WHERE option_name = 'siteurl' OR option_name = 'home' ;

UPDATE mz_2_options SET option_value = REPLACE(option_value, 'dev.gioli.com.br', 'clinicasavioli.com.br') WHERE option_name = 'siteurl' OR option_name = 'home' ;

UPDATE mz_3_options SET option_value = REPLACE(option_value, 'dev.gioli.com.br', 'clinicasavioli.com.br') WHERE option_name = 'siteurl' OR option_name = 'home' ;


UPDATE mz_posts SET post_content = REPLACE(post_content, 'dev.gioli.com.br', 'clinicasavioli.com.br'), guid = REPLACE(post_content, 'dev.gioli.com.br', 'clinicasavioli.com.br');
UPDATE mz_2_posts SET post_content = REPLACE(post_content, 'dev.gioli.com.br', 'clinicasavioli.com.br'), guid = REPLACE(post_content, 'dev.gioli.com.br', 'clinicasavioli.com.br');
UPDATE mz_3_posts SET post_content = REPLACE(post_content, 'dev.gioli.com.br', 'clinicasavioli.com.br'), guid = REPLACE(post_content, 'dev.gioli.com.br', 'clinicasavioli.com.br');


UPDATE mz_postmeta SET meta_value = REPLACE(meta_value, 'dev.gioli.com.br', 'clinicasavioli.com.br');
UPDATE mz_2_postmeta SET meta_value = REPLACE(meta_value, 'dev.gioli.com.br', 'clinicasavioli.com.br');
UPDATE mz_3_postmeta SET meta_value = REPLACE(meta_value, 'dev.gioli.com.br', 'clinicasavioli.com.br');