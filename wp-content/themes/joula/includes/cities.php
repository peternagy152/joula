<?php
add_filter( 'wc_city_select_cities', 'my_cities' );
/**
 * Replace XX with the country code. Instead of YYY, ZZZ use actual  state codes.
 */

function my_cities( $cities ) {
    $cities['QAT'] = array(
        'YYY' => array(
            'City1',
            'City2'
        ),
        'YYY' => array(
            'City Center',
            'City Corniche'
        )
    );
    return $cities;
}
