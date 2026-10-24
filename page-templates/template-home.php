<?php
/**
 * Template Name: Whalebone Home
 * Template Post Type: page
 *
 * Animated one-page home for The Whalebone Inn.
 * Intentionally has no links to other pages: every button scrolls within this page.
 *
 * @package whalebone-child
 */

defined( 'ABSPATH' ) || exit;

$dishes = array(
	array( 'cut-breakfast.webp', 'THE FULL ENGLISH' ),
	array( 'cut-roast.webp', 'SUNDAY ROAST' ),
	array( 'cut-tapas.webp', 'TAPAS, 3 FOR £10' ),
);
$diamond = '<span class="wb-diamond" aria-hidden="true"></span>';
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'wb-landing is-loading' ); ?>>
<?php wp_body_open(); ?>

<!-- Preloader -->
<div class="wb-loader" aria-hidden="true">
	<div class="wb-loader__ring"></div>
	<img src="<?php echo whalebone_img( 'logo-round.webp' ); ?>" alt="" class="wb-loader__logo">
	<div class="wb-loader__text">EST 1735</div>
	<div class="wb-loader__curtain wb-loader__curtain--a"></div>
	<div class="wb-loader__curtain wb-loader__curtain--b"></div>
</div>

<div class="wb-progress" aria-hidden="true"><span></span></div>
<div class="wb-cursor" aria-hidden="true"><span></span></div>

<div class="wb-page">

<!-- Header -->
<header class="wb-header">
	<button type="button" class="wb-logo" data-goto="#top" aria-label="Back to top">
		<img src="<?php echo whalebone_img( 'logo-round.webp' ); ?>" alt="The Whalebone Inn" width="72" height="72">
	</button>
	<nav class="wb-nav" aria-label="Sections">
		<span class="wb-nav__pill" aria-hidden="true"></span>
		<button type="button" class="is-active" data-goto="#top">Home</button>
		<button type="button" data-goto="#whats-on">What's On</button>
		<button type="button" data-goto="#kitchen">Food</button>
		<button type="button" data-goto="#hire">Private Hire</button>
		<button type="button" data-goto="#find-us">Find Us</button>
	</nav>
	<button type="button" class="wb-btn wb-btn--gold wb-btn--sm wb-magnetic" data-goto="#book"><span>BOOK A TABLE</span></button>
	<button type="button" class="wb-burger" aria-label="Menu" aria-expanded="false"><span></span><span></span><span></span></button>
</header>

<!-- Mobile menu -->
<div class="wb-mobile-menu" aria-hidden="true">
	<button type="button" data-goto="#top">Home</button>
	<button type="button" data-goto="#whats-on">What's On</button>
	<button type="button" data-goto="#kitchen">Food</button>
	<button type="button" data-goto="#hire">Private Hire</button>
	<button type="button" data-goto="#find-us">Find Us</button>
</div>

<main id="top">

<!-- HERO -->
<section class="wb-hero" data-section>
	<div class="wb-hero__tab" data-parallax="-0.08">
		<div class="wb-hero__est"><span>EST</span> <span>1735</span></div>
	</div>

	<div class="wb-hero__glow" aria-hidden="true"></div>

	<div class="wb-hero__plate-wrap" data-parallax="0.12">
		<div class="wb-hero__orbit" aria-hidden="true"></div>
		<div class="wb-hero__plate wb-float">
			<?php foreach ( $dishes as $i => $d ) : ?>
				<img src="<?php echo whalebone_img( $d[0] ); ?>" alt="<?php echo esc_attr( ucwords( strtolower( $d[1] ) ) ); ?>" class="<?php echo 0 === $i ? 'is-active' : ''; ?>" data-dish="<?php echo (int) $i; ?>" width="440" height="440" <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
			<?php endforeach; ?>
		</div>
		<div class="wb-hero__label"><span><?php echo esc_html( $dishes[0][1] ); ?></span></div>
		<img src="<?php echo whalebone_img( 'cut-pint.webp' ); ?>" alt="" class="wb-hero__pint wb-float wb-float--slow" aria-hidden="true">
	</div>

	<div class="wb-hero__copy">
		<div class="wb-hero__kicker wb-type" data-text="WHERE EVERY PINT TELLS A STORY."></div>
		<h1 class="wb-hero__title">
			<span class="wb-line"><span class="wb-split">Proper pub.</span></span>
			<span class="wb-line"><span class="wb-split wb-gold">Proper welcome.</span></span>
		</h1>
		<p class="wb-hero__lead wb-intro" style="--d:1.2s">Homemade food, Sunday roasts, live music and a warm welcome in South Woodham Ferrers.</p>
		<div class="wb-hero__ctas wb-intro" style="--d:1.35s">
			<button type="button" class="wb-btn wb-btn--gold wb-btn--glow wb-magnetic" data-goto="#book"><span>BOOK A TABLE</span></button>
			<button type="button" class="wb-btn wb-btn--cream wb-magnetic" data-goto="#whats-on"><span>WHAT'S ON</span></button>
		</div>
		<ul class="wb-badges">
			<li class="wb-intro" style="--d:1.5s"><?php echo $diamond; ?>EST. 1735</li>
			<li class="wb-intro" style="--d:1.58s"><?php echo $diamond; ?>DOG FRIENDLY</li>
			<li class="wb-intro" style="--d:1.66s"><?php echo $diamond; ?>FAMILY FRIENDLY</li>
			<li class="wb-intro" style="--d:1.74s"><?php echo $diamond; ?><span><span class="wb-count" data-to="98">0</span>% RECOMMEND</span></li>
		</ul>
	</div>

	<div class="wb-hero__picker wb-intro wb-intro--left" style="--d:1.6s">
		<?php foreach ( $dishes as $i => $d ) : ?>
			<button type="button" class="wb-thumb<?php echo 0 === $i ? ' is-active' : ''; ?>" data-pick="<?php echo (int) $i; ?>" data-name="<?php echo esc_attr( $d[1] ); ?>" aria-label="Show <?php echo esc_attr( ucwords( strtolower( $d[1] ) ) ); ?>">
				<img src="<?php echo whalebone_img( $d[0] ); ?>" alt="" width="78" height="78">
				<svg class="wb-thumb__timer" viewBox="0 0 40 40" aria-hidden="true"><circle cx="20" cy="20" r="19"/></svg>
			</button>
		<?php endforeach; ?>
		<div class="wb-hero__hint">TAP A PLATE</div>
	</div>

	<button type="button" class="wb-scroll-cue" data-goto="#whats-on" aria-label="Scroll down"><span></span></button>
</section>

<!-- WHAT'S ON -->
<section class="wb-events" id="whats-on" data-section>
	<div class="wb-bar" data-anim="bar">
		<div class="wb-bar__tag">WHAT'S ON</div>
		<div class="wb-bar__track">
			<div class="wb-bar__note">Book online. No more messaging us on Facebook.</div>
			<button type="button" class="wb-bar__link" data-goto="#book">ALL EVENTS <span>→</span></button>
		</div>
	</div>

	<div class="wb-events__grid">
		<article class="wb-card wb-tilt" data-anim="up" data-delay="0">
			<div class="wb-date"><b>22</b><i>OCT</i></div>
			<div class="wb-card__meta">THURSDAY · 7:30PM</div>
			<h3>Quiz Night</h3>
			<dl class="wb-card__list">
				<div><dt>ENTRY</dt><dd>£5 PER PERSON</dd></div>
				<div><dt>TEAMS</dt><dd>UP TO 6</dd></div>
				<div><dt>PRIZES</dt><dd>YES</dd></div>
			</dl>
			<button type="button" class="wb-btn wb-btn--dark wb-btn--xs" data-goto="#book"><span>JOIN THE QUIZ</span></button>
		</article>

		<article class="wb-card wb-card--feature wb-tilt" data-anim="zoom" data-delay="150">
			<div class="wb-date wb-date--lg"><b>7</b><i>NOV</i></div>
			<div class="wb-card__flag">LIMITED SPACES</div>
			<div class="wb-card__meta">SATURDAY · 3PM · SOUL AND MOTOWN</div>
			<h3>A Tribute to Stevie Wonder</h3>
			<p>Includes food and bottomless drinks.</p>
			<div class="wb-card__foot">
				<div class="wb-price">£<span class="wb-count" data-to="45">0</span><small> PP</small></div>
				<button type="button" class="wb-btn wb-btn--ink wb-magnetic" data-goto="#book"><span>BOOK TICKETS</span></button>
			</div>
			<div class="wb-card__shine" aria-hidden="true"></div>
		</article>

		<article class="wb-card wb-tilt" data-anim="up" data-delay="300">
			<div class="wb-date"><b>31</b><i>OCT</i></div>
			<div class="wb-card__meta">SATURDAY · 7PM</div>
			<h3>Halloween Party</h3>
			<dl class="wb-card__list">
				<div><dt>DRESS</dt><dd>FANCY DRESS</dd></div>
				<div><dt>MUSIC</dt><dd>DJ TANIA C</dd></div>
				<div><dt>PLUS</dt><dd>COCKTAILS, GAMES, PRIZES</dd></div>
			</dl>
			<button type="button" class="wb-btn wb-btn--dark wb-btn--xs" data-goto="#book"><span>FIND OUT MORE</span></button>
		</article>
	</div>
</section>

<!-- SINCE 1735 -->
<section class="wb-since" data-section>
	<div class="wb-since__big" aria-label="Since 1735">
		<span class="wb-since__row" data-parallax-x="-0.15">SINCE</span>
		<span class="wb-since__row" data-parallax-x="0.15">1735</span>
	</div>
	<img src="<?php echo whalebone_img( 'cut-roasts.webp' ); ?>" alt="Sunday roasts on the pass" class="wb-since__plate wb-spin-scroll" loading="lazy" width="240" height="240">
	<p class="wb-since__l" data-anim="left">Nearly 300 years on Old Wickford Road, and still the local.</p>
	<p class="wb-since__r" data-anim="right">Known to regulars as The Bone. Homemade food, weekly specials and a proper welcome.</p>
	<div class="wb-ribbon wb-ribbon--tilt">
		<div class="wb-marquee" data-speed="40">
			<?php for ( $k = 0; $k < 2; $k++ ) : ?>
			<div class="wb-marquee__set">
				<span>THE WHALEBONE INN</span><?php echo $diamond; ?><span>EST 1735</span><?php echo $diamond; ?><span>THE BONE</span><?php echo $diamond; ?><span>THE WHALEBONE INN</span><?php echo $diamond; ?><span>EST 1735</span><?php echo $diamond; ?><span>THE BONE</span><?php echo $diamond; ?>
			</div>
			<?php endfor; ?>
		</div>
	</div>
</section>

<!-- KITCHEN -->
<section class="wb-kitchen" id="kitchen" data-section>
	<div class="wb-flag" data-anim="clip">
		<div class="wb-flag__text">FROM THE KITCHEN</div>
		<div class="wb-flag__tail"></div>
	</div>
	<div class="wb-kitchen__grid">
		<?php
		$plates = array(
			array( 'cut-roast.webp', 'SUNDAY ROASTS', 'Renowned locally. Booking ahead is a good idea.', 'Sunday roast' ),
			array( 'cut-breakfast.webp', 'FULL ENGLISH', 'Fresh and homemade, the proper way.', 'Full English breakfast' ),
			array( 'cut-tapas.webp', 'WEEKLY SPECIALS', 'This weekend: tapas, 3 for £10.', 'Tapas' ),
		);
		foreach ( $plates as $i => $p ) :
			?>
			<div class="wb-dish" data-anim="rise" data-delay="<?php echo (int) $i * 140; ?>">
				<div class="wb-dish__disc">
					<span class="wb-dish__ring" aria-hidden="true"></span>
					<img src="<?php echo whalebone_img( $p[0] ); ?>" alt="<?php echo esc_attr( $p[3] ); ?>" loading="lazy" width="340" height="340" class="wb-float" style="--fd:<?php echo 5 + $i; ?>s;--fo:<?php echo $i * -1.4; ?>s">
				</div>
				<h3><?php echo esc_html( $p[1] ); ?></h3>
				<p><?php echo esc_html( $p[2] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<button type="button" class="wb-btn wb-btn--gold wb-btn--glow wb-magnetic" data-anim="zoom" data-goto="#book"><span>BOOK A TABLE</span></button>
</section>

<!-- PRIVATE HIRE -->
<section class="wb-hire" id="hire" data-section>
	<div class="wb-hire__tab" data-anim="drop"><span>PRIVATE HIRE</span></div>
	<div class="wb-hire__img" data-anim="spin">
		<img src="<?php echo whalebone_img( 'cut-buffet.webp' ); ?>" alt="Private hire buffet spread" loading="lazy" width="460" height="460" class="wb-spin-scroll" data-spin="0.15">
	</div>
	<div class="wb-hire__copy">
		<h2 data-anim="up"><span>Your party,</span> <span class="wb-gold">our place</span></h2>
		<p data-anim="up" data-delay="120">Birthdays, celebrations and get-togethers, with buffets made in our kitchen. Family and dog friendly.</p>
		<button type="button" class="wb-btn wb-btn--cream wb-magnetic" data-anim="up" data-delay="240" data-goto="#book"><span>ENQUIRE ABOUT HIRE</span></button>
	</div>
</section>

<div class="wb-ribbon wb-ribbon--flat">
	<div class="wb-marquee wb-marquee--rev" data-speed="50">
		<?php for ( $k = 0; $k < 2; $k++ ) : ?>
		<div class="wb-marquee__set">
			<span>LIVE MUSIC</span><?php echo $diamond; ?><span>QUIZ NIGHTS</span><?php echo $diamond; ?><span>SUNDAY ROASTS</span><?php echo $diamond; ?><span>TRIBUTE AFTERNOONS</span><?php echo $diamond; ?><span>DOG FRIENDLY</span><?php echo $diamond; ?>
		</div>
		<?php endfor; ?>
	</div>
</div>

</main>

<!-- FOOTER -->
<footer class="wb-footer" id="find-us" data-section>
	<div class="wb-footer__grid">
		<div class="wb-panel wb-panel--cream" data-anim="left">
			<div class="wb-panel__title">FIND US</div>
			<p>Old Wickford Road<br>South Woodham Ferrers, Essex</p>
			<button type="button" class="wb-btn wb-btn--dark wb-btn--xs wb-copy" data-copy="The Whalebone Inn, Old Wickford Road, South Woodham Ferrers, Essex"><span>COPY ADDRESS</span></button>
		</div>
		<div class="wb-panel wb-panel--green" id="book" data-anim="right">
			<div>
				<div class="wb-panel__title">SAVE YOUR SEAT</div>
				<p>Book a table in under a minute. <span class="wb-count" data-to="98">0</span>% of our Facebook reviewers recommend us.</p>
			</div>
			<button type="button" class="wb-btn wb-btn--gold wb-btn--glow wb-magnetic wb-book-now"><span>BOOK A TABLE</span></button>
		</div>
	</div>
	<div class="wb-footer__bar" data-anim="up">
		<button type="button" class="wb-footer__logo" data-goto="#top" aria-label="Back to top">
			<img src="<?php echo whalebone_img( 'logo-round.webp' ); ?>" alt="The Whalebone Inn" width="128" height="128" loading="lazy">
		</button>
		<div class="wb-footer__copy">© The Whalebone Inn · Est. 1735</div>
	</div>
	<div class="wb-footer__giant" aria-hidden="true"><span>THE WHALEBONE INN</span></div>
</footer>

<!-- Mobile sticky bar -->
<div class="wb-sticky">
	<button type="button" class="wb-btn wb-btn--gold" data-goto="#book"><span>BOOK A TABLE</span></button>
	<button type="button" class="wb-btn wb-btn--cream" data-goto="#find-us"><span>FIND US</span></button>
</div>

<div class="wb-toast" role="status" aria-live="polite"></div>

</div><!-- .wb-page -->

<?php wp_footer(); ?>
</body>
</html>
