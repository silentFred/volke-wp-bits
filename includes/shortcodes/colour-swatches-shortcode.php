<?php

// Volke Tools Colour swatch list
function colour_swatches_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(),
        $atts
    );

    $data_attributes = [];
    foreach ($atts as $key => $value) {
        $data_attributes[] = 'data-' . $key . '="' . $value . '"';
    }

    $data_attributes = join(' ', $data_attributes);

    $colour_taxonomies = get_terms(['taxonomy' => 'pa_colours', 'hide_empty' => false]);
    $html = '';
    foreach ($colour_taxonomies as $colour_taxonomy) {

        $term = get_term($colour_taxonomy);
        $term_attachment = get_term_meta($term->term_id, 'product_attribute_image', true);
        $image = wp_get_attachment_image_src($term_attachment, 'medium')[0];

        $html .= "
        <div style='display: flex'>
            <div style='flex: 1'>
                <img src='$image' alt='$term->name'/>
            </div>
            
            <div style='flex: 3'>
                <h2>$term->name</h2>
                <p>$term->description</p>
                <a href='/?filter_colours=$term->slug&s=&post_type=product'>See all</a>
            </div>
        </div>";
    }

    return $html;
}

add_shortcode('colour_swatches', 'colour_swatches_shortcode');