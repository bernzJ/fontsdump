<?php
/**
 * Content for a single resume.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/content-single-resume.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager-resumes
 * @category    Template
 * @version     1.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

if ( resume_manager_user_can_view_resume( $post->ID ) ) : ?>
 
 <?php echo get_post_meta( $post->ID, '_candidate_color', true ); ?>
        
    <!-- ===== Start of Resume Header ===== -->
    <?php
    $image = get_post_meta($post->ID, '_featured_image', true);

    if( !empty($image) ) { ?>
        <section class="page-header resume-header overlay-gradient" style="background: url(<?php echo esc_attr($image); ?>);">
    <?php } else { ?>
        <section class="page-header resume-header overlay-gradient">
    <?php } ?>

    </section>
    <!-- ===== End of Resume Header ===== -->




    <!-- ===== Start of Main Wrapper ===== -->
    <main>      
        <article id="post-<?php the_ID(); ?>" <?php post_class('resume-page'); ?>>
            <div class="container">

                <!-- Start of Candidate main resume -->
                <div class="candidate-main-resume">

                    <!-- Start of Candidate Extro Info -->
                    <div class="candidate-extra-info">

                        <?php
                        if ( get_option( 'resume_manager_enable_categories' ) ) {
                            $categories = wp_get_object_terms( $post->ID, 'resume_category');

                            if ( is_wp_error( $categories ) ) {
                                return '';
                            }

                            echo '<div class="left-side"><ul class="candidate-categories">';
                            foreach ( $categories as $category ) {
                                echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a></li>';
                            }
                            echo '</ul></div>';
                        } ?>

                        <div class="right-side">
                            <div class="location">
                                <i class="icon-location-pin"></i>
                                <?php the_candidate_location( false ); ?>
                            </div>

                            <div class="published-date">
                                <i class="icon-clock"></i>
                                <?php printf( '%s %s', esc_html__( 'Member Since ', 'cariera' ) , get_the_date('Y')); ?>
                            </div>

                            <?php if ( resume_has_file() ) {
                                if ( ( $resume_files = get_resume_files() ) && apply_filters( 'resume_manager_user_can_download_resume_file', true, $post->ID ) ) {
                                    foreach ( $resume_files as $key => $resume_file ) { ?>
                                        <div class="candidate-resume">
                                            <a href="<?php echo esc_url( get_resume_file_download_url( null, $key ) ); ?>"><?php esc_html_e('Download CV', 'cariera') ?></a>
                                        </div>
                                    <?php }
                                }
                            } ?>
                        </div>

                    </div>
                    <!-- Start of Candidate Extro Info -->


                    <!-- Start of Candidate Info Wrapper -->
                    <div class="candidate-info-wrapper">

                        <!-- <div class="candidate-photo">
                            <?php//	the_candidate_photo(); ?>
                        </div> -->


                        <div class="candidate">
                            <?php $featured = get_post_meta( $post->ID, '_featured', true );
                            //echo ( $featured == true ) ? '<i class="featured-listing icon-energy" title="' . esc_attr__( 'Featured', 'cariera' )  . '"></i>' : ''; ?>
                            <h1 class="title"><?php the_title(); ?></h1>

                            <?php if ( resume_manager_user_can_view_contact_details( $post->ID ) )  {
                                do_action( 'single_resume_contact_start' ); ?>

                                <div class="candidate-links">
                                    <?php foreach( get_resume_links() as $link ) {
                                        $parsed_url = parse_url( $link['url'] );
                                        $host       = isset( $parsed_url['host'] ) ? current( explode( '.', $parsed_url['host'] ) ) : ''; ?>
                                        <span class="links">
                                            <a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank"><i class="fas fa-link"></i> <?php echo esc_html( $link['name'] ); ?></a>
                                        </span>
                                    <?php }

                                    $email = get_post_meta( $post->ID, '_candidate_email', true );
                                    if ( $email ) { ?>
                                        <span class="candidate-email">
                                            <a href="mailto:<?php echo esc_url( $email ); ?>"><i class="icon-envelope"></i><?php echo esc_html($email); ?></a>
                                        </span>
                                    <?php } ?>
                                </div> <!-- .candidate-info -->

                                <?php do_action( 'single_resume_contact_end' );
                            } else {
                                get_job_manager_template_part( 'access-denied', 'contact-details', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
                            } ?>
                            
                            <?php do_action('cariera_candidate_socials'); ?>
                        </div>

                        <!-- Start of Bookmark -->
                        <div class="bookmark-wrapper">
                            <?php get_job_manager_template( 'contact-details.php', array( 'post' => $post ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
                            do_action('cariera_bookmark_hook'); ?>
                        </div>
                        <!-- End of Bookmark -->

                    </div>
                    <!-- End of Candidate Info Wrapper -->

                </div>
                <!-- End of Candidate main resume -->
                
                <!-- Todally Custom Layout -->
                <div class="ctcustom-container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="car-details-content">
                                <!-- <h2>About the Vehicles</h2> -->

                                <div class="car-engine-details car-details">
                                    <h3>Car Details</h3>
                                    <?php 
                                        $vehicle_brand = get_post_meta( $post->ID, '_vehicle_brand', true );
                                        $vehicle_model = get_post_meta( $post->ID, '_vehicle_model', true );
                                        $vehicle_mileage = get_post_meta( $post->ID, '_vehicle_mileage', true );
                                        $vehicle_size = get_post_meta( $post->ID, '_vehicle_size', true );
                                        $price = get_post_meta( $post->ID, '_price', true );
                                        $liability_insurance = get_post_meta( $post->ID, '__insurance', true );
                                        $cargo_insurance = get_post_meta( $post->ID, '__cargo_insurance', true );
                                        $type_of_business = get_post_meta( $post->ID, '_candidate_title', true );
                                        $type_of_contract = get_post_meta( $post->ID, '_type_of_contract', true );
                                        $region = get_post_meta( $post->ID, '_region', true );
                                    ?>
                                    <ul>
                                        <li> Brand <span> <?php echo esc_html($vehicle_brand); ?> </span> </li>
                                        <li> Model <span> <?php echo esc_html($vehicle_model); ?> </span> </li>
                                        <li> Mileage <span> <?php echo esc_html($vehicle_mileage); ?> </span> </li>
                                        <li> Size <span> <?php echo esc_html($vehicle_size); ?> </span> </li>
                                    </ul>
                                </div>
                                <div class="car-fetures car-details">
                                    <h3>Equipement Included</h3>
                                    <?php 
                                        $equipment_includeds = get_post_meta( $post->ID, '_equipment_included', true );
                                    ?>
                                    <ol>
                                        <?php 
                                            foreach($equipment_includeds as $key => $equipment) { 
                                                echo '<li> <i class="fas fa-check-square"></i>'. $equipment .'</li>';
                                            } 
                                         ?>
                                    </ol>
                                </div>

                            </div>

                            <div class="custom_show_view_fields">
                                <p>
                                    <?php 
                                        $certifications = wp_get_object_terms( $post->ID, 'job_listing_qualification');
                                        $total_certifications = count($certifications)-1;

                                        $payments = wp_get_object_terms( $post->ID, 'payement_by');
                                        $total_payments = count($payments)-1;
                                    ?>
                                </p>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="car-sidebar">
                                <div class="car-sidebar-widget no-padding">  
                                    <div class="car-price"><?php echo esc_html($price); ?>$/day</div>
                                </div>
                                <div class="car-sidebar-widget">
                                    <h2 class="widget-title">Owner Overview</h2>
                                    <div class="car-widget-inner">
                                        <ul>
                                            <li> Libaliity insurance: <span> <?php echo esc_html($liability_insurance); ?> </span> </li>
                                            <li> Cargo insurance <span> <?php echo esc_html($cargo_insurance); ?> </span> </li>
                                            <li> Type of Business: <span> <?php echo esc_html($type_of_business); ?> </span> </li>
                                            <li> Certifications <span> <?php 
                                                foreach ($certifications as $key => $certificate) {
                                                   echo $certificate->name; 
                                                   if($total_certifications != $key){
                                                        echo ", ";
                                                   }
                                                }
                                            ?> </span> </li>
                                            <li> Schedule <span> 10+ Years </span> </li>
                                            <li> Type of contract <span> <?php echo esc_html($type_of_contract); ?> </span> </li>
                                            <li> Region <span> <?php echo esc_html($region); ?> </span> </li>
                                            <li> Payment <span> <?php 
                                                foreach ($payments as $key => $payment) {
                                                   echo $payment->name; 
                                                   if($total_payments != $key){
                                                        echo ", ";
                                                   }
                                                }
                                             ?> </span> </li>
                                            <li> Desired Amount <span> between and between </span> </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Totally Custom Layout -->


                <!-- Start of the Main Candidate Content -->
                <div class="row pb80">

                    <!-- RESUME CONTENT HERE -->
                    <div class="col-md-8 col-xs-12">
                        <?php
                        do_action( 'single_resume_start' );
                        do_action( 'single_resume_content' );
                        do_action( 'single_resume_end' );
                        ?>
                    </div>

                    <?php /* get_sidebar('single-resume'); */ ?>
                </div>
                <!-- End of the Main Candidate Content -->

            </div>
        </article>
    </main>
    <!-- ===== End of Main Wrapper ===== -->

<?php else :
    get_job_manager_template_part( 'access-denied', 'single-resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
endif;