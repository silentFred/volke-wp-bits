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
        $link = "/shop/?filter_colours=$term->slug";

        $html .= "
        <p>
            <div style='display: flex'>
                <div style='flex: 1'>
                    <a href='$link'>
                        <img style='padding: 10px' src='$image' alt='$term->name'/>
                    </a>
                </div>
                
                <div style='flex: 3'>
                    <div style='padding: 10px'>
                        <h3>$term->name</h3>
                        <p>$term->description</p>
                        <a href='$link'>View all $term->name products</a>
                    </div>
                </div>
            </div>
        </p>";
    }

    return $html;
}

add_shortcode('colour_swatches', 'colour_swatches_shortcode');