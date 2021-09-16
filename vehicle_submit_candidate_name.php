<?php
$user_id = get_current_user_id();
$user_name = get_user_meta($user_id, 'user_login');

?>

<script>
  jQuery(document).ready(function($) {
    var values_cat = [];
    var final_brand = '';

    function get_text(val) {
      let text_cat = jQuery('#vehicle_type option[value="' + val + '"]').html();
      //console.log(text_cat);
      values_cat.push(text_cat);
    }

    function get_model(val) {
      var text_brand = jQuery('#vehicle_model option[value="' + val + '"]').html();
      final_brand = text_brand;
      //console.log(text_brand);
    }
    $('#vehicle_type').change(function() {
      let values_cat = jQuery('#vehicle_type').val();
      values_cat.forEach(get_text);
      print_text();
    });
    $('#vehicle_model').change(function() {
      let values_brand = jQuery('#vehicle_model').val();
      get_model(values_brand);
      print_text();
    });

    function print_text() {
      var uniquecats = [];
      $.each(values_cat, function(i, el) {
        if ($.inArray(el, uniquecats) === -1) uniquecats.push(el);
      });
      print_cats = uniquecats.toString();
      candidate_tags = '<?= $user_name; ?>' + print_cats + ' | ' + final_brand;
      //console.log(print_cats);
      jQuery('.text-candidate_name').val(candidate_tags);
    }
  });
</script>