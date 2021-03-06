<?php
/*
Template Name: Achievements
*/
?>
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>


						<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>
						<h1 class="entry-title"><?php the_title();?></h1>
						<div class="entry-title">
						</div>
						<div class="achiBox">
					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
					
					<?php 	
					global $current_user;
					global $wpdb;
					get_currentuserinfo(); 
				
				//Kod som hämtar ut ens egna achievements och om de är avklarade eller inte
				$result = $wpdb->get_results( "SELECT * FROM wp_achievements WHERE username = '$current_user->user_login'");

				if(empty($current_user->user_login)){
					echo "You need to login to see your achievements!";
					
					//Visar ett loginformulär om ingen användare är inloggad
					//wp_login_form();
					echo "<br><a href='http://127.0.0.1/Projektarbeteigrupp/wp-login.php'>Log in</a>";
				}
				else{
					$single = "'";
					$double = '"';
		
					//Visar update-knappen för admin
						global $user_ID; 
						
						//Visar achievements från databasen och skapar länkar så att de kan delas
						
						foreach($result as $row)
						{
							$desc = $wpdb->get_results( "SELECT description,imgpath FROM wp_achievementlist WHERE name = '$row->achievement'");
							foreach($desc as $descRow){

							$status = "In Progress";
							if($row->achievementIsDone == 1){
								$status = "Done";
								echo "<div class='boxDone'>";
								echo "<img src='".$descRow->imgpath ."' alt='test' height='100' width='100'>";
								echo $row->achievementCompletedDate;
								echo "<div class='achiName'>" . $row->achievement . "</div> " . "<div class='achiDesc'>" . $descRow->description . "</div>" . "<div class='achiStatus'>Achivement status: " . $status . "</div>" . 
								"<div class='achiShare'><a href='http://127.0.0.1/Projektarbeteigrupp/?page_id=43&user=$current_user->user_login" . 
								"&" . "achievement=$row->achievement' class='shareLink'>Share</a>" . "</div>";
								echo"</div>";
							}
							if($row->achievementIsDone == 0)
							{
								
								echo "<div class='boxNotDone'>";
								echo "<img src='". $descRow->imgpath ."' alt='test' height='100' width='100'>";
								echo $row->achievementCompletedDate;
								echo "<div class='achiName'>" . $row->achievement . "</div>" . "<div class='achiDesc'>" . $descRow->description . "</div>" . "<div class='achiStatus'>Achivement status: " . $status . "</div>";
								echo"</div>";
							}
							}
							
						}
						
						if( $user_ID ){
							if( current_user_can('level_10') ){
								echo "<form method='POST' class='message' action='http://127.0.0.1/achievements/UpdateAchievement.php' id='hideMe'>
								<p>This will update all achievements on the user so they will have the latest list of achievements. Only the Admin user can use this function. This function will not delete or change the status of the achievements, it will only add those achievements that is missing on the users.</p>
								<br><p>Username</p>
								<input type='text' name='username' value=''>
								<br><p>Password</p>
								<input type='password' name='password' value=''>
								<br><br><input type='submit' name='submit' value='Update achievements'>
								</form>";
							}
						}
					}
					echo "<div class='searchUser'>Search for a user";
					echo "<form action='http://127.0.0.1/Projektarbeteigrupp/user/' method='GET'>
						<input name='user' type='text' value=''/>
						<input type='submit' value='Search'>
					</form>";
					
					echo "<a href='http://127.0.0.1/Projektarbeteigrupp/user/?showAll'>Show all members</a></div>";
					
					?>
					
					
					</div>
					
					</header><!-- .entry-header -->

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			

			
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					


					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					
				</article><!-- #post -->


			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>