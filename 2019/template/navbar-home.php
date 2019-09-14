<!-- =========================
     NAVIGATION LINKS
============================== -->
<div class="navbar navbar-fixed-top custom-navbar" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand"><?= esc_html( $conference->getConferenceTitle() ) ?></a>
		</div>

		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-right">
				<li><a href="#intro" class="smoothScroll">Intro</a></li>
				<li><a href="#overview" class="smoothScroll">Overview</a></li>
				<li><a href="#program" class="smoothScroll">Programs</a></li>
				<li><a href="#venue" class="smoothScroll">Venue</a></li>
				<li><a href="#sponsors" class="smoothScroll">Sponsors</a></li>
				<li><a href="#contact" class="smoothScroll">Contact</a></li>
			</ul>

		</div>
	</div>
</div>
