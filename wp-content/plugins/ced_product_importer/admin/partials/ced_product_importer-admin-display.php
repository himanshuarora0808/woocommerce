<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class Customers_List extends WP_List_Table {

/** Class constructor */
public function __construct() {

    parent::__construct( [
        'singular' => __( 'Customer', 'sp' ), //singular name of the listed records
        'plural'   => __( 'Customers', 'sp' ), //plural name of the listed records
        'ajax'     => false //should this table support ajax?

    ] );

}

/**$item
 *  Associative array of columns
 *
 * @return array
 */
function get_columns() {
    $columns = [
      'cb'      => '<input type="checkbox"  >',
      'Image'    => __( 'Image', 'sp' ),
      'Title'    => __( 'Title', 'sp' ),
      'Sku' => __( 'Sku', 'sp' ),
      'Price'    => __( 'Price', 'sp' ),
      'Type'    => __( 'Type', 'sp' ),
      'Action'    => __( 'Action', 'sp' )
    ];
  
    return $columns;
  }

/**
 * Render a column when no column specific method exists.
 *
 * @param array $item
 * @param string $column_name
 *
 * @return mixed
 */
public function column_default( $item, $column_name ) {
    switch ( $column_name ) {
      case 'Image':
        return '<img src='.$item['item']['images'][0].' height="100" width="100">';     
      case 'Title':
        return $item['item']['name'];
      case 'Sku':
        return $item['item']['item_sku'];
      case 'Price':
        return $item['item']['price'];
      case 'Type':
        if(1 == $item['item']['has_variation'] || true == $item['item']['has_variation'] ){
            return 'variable';
        }
        else{
            return 'simple';
        }
      case 'Action':
         return '<input type="button" data-id="'.$item['item']['item_sku'].'" value="Import Product" class="import">';      

    }
  }


  function get_bulk_actions() {
    $actions = array(
      'import'    => 'Import'
    );
    return $actions;
  }
  
  function column_cb($item) {
    return sprintf(
        '<input type="checkbox" class="checks" name="book[]" value="'.$item['item']['item_sku'].'" />' );    
}

/**
 * Handles data query and filter, sorting, and pagination.
 */
    public function prepare_items() {

    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers =array($columns, $hidden, $sortable);
  }
}

?>
