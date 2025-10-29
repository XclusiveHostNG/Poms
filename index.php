<?php
require_once __DIR__ . '/config/Database.php';

$pageTitle = 'Home';
$database = Database::getInstance();
$siteSettings = $database->fetchSiteSettings();
$latestPosts = $database->fetchLatestBlogPosts(3);
$upcomingEvents = $database->fetchUpcomingEvents(3);

require __DIR__ . '/includes/header.php';
?>
<section class="hero-banner">
    <div class="container">
        <h1 class="mb-4">Empowering Democratic Participation</h1>
        <p class="mb-4 lead">Join us in building a stronger, more engaged community through innovative political organisation management.</p>
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="<?= $baseUrl; ?>auth/register" class="btn btn-warning btn-lg px-4"><i class="fa-solid fa-user-plus me-2"></i>Become a Member</a>
            <a href="<?= $baseUrl; ?>pages/manifestoes" class="btn btn-outline-light btn-lg px-4"><i class="fa-solid fa-book me-2"></i>Explore Manifestoes</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Why Choose POMS?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card h-100">
                    <div class="card-body">
                        <div class="icon-circle bg-primary text-white mb-3"><i class="fa-solid fa-users"></i></div>
                        <h5 class="card-title">Inclusive Community</h5>
                        <p class="card-text">Connect with members and aspirants from your region, share ideas, and collaborate on transformative initiatives.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100">
                    <div class="card-body">
                        <div class="icon-circle bg-success text-white mb-3"><i class="fa-solid fa-id-card"></i></div>
                        <h5 class="card-title">Secure Identity</h5>
                        <p class="card-text">Complete onboarding, verify your identity, and access your personalized membership ID card anytime.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card h-100">
                    <div class="card-body">
                        <div class="icon-circle bg-warning text-white mb-3"><i class="fa-solid fa-bullhorn"></i></div>
                        <h5 class="card-title">Effective Campaigns</h5>
                        <p class="card-text">Organize events, campaigns, and grassroots mobilisation activities with built-in tools for aspirants and administrators.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Seamless Onboarding</h2>
                <p>Our step-by-step onboarding process guides new members and aspirants through profile completion, KYC verification, and WhatsApp group integration tailored to their region.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Complete personal and demographic information.</li>
                    <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Verify your identity and submit necessary documents.</li>
                    <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Access regional WhatsApp groups and events.</li>
                </ul>
                <a href="<?= $baseUrl; ?>auth/register" class="btn btn-primary mt-3">Get Started</a>
            </div>
            <div class="col-lg-6">
                <img src="<?= $baseUrl; ?>assets/images/onboarding.svg" class="img-fluid" alt="Onboarding Illustration" />
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-3 mb-md-0">Upcoming Events</h2>
            <a href="<?= $baseUrl; ?>pages/events" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-calendar-days me-1"></i>View all events</a>
        </div>
        <div class="row g-4">
            <?php if (!empty($upcomingEvents)): ?>
                <?php foreach ($upcomingEvents as $event): ?>
                    <div class="col-md-4">
                        <div class="card event-card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-2"><?= htmlspecialchars($event['title']); ?></h5>
                                <p class="small text-muted mb-3"><i class="fa-solid fa-location-dot me-2"></i><?= htmlspecialchars($event['venue'] ?? 'Venue TBA'); ?></p>
                                <p class="small mb-0"><i class="fa-solid fa-clock me-2"></i><?= date('d M Y, g:ia', strtotime($event['start_date'])); ?></p>
                                <?php if (!empty($event['end_date'])): ?>
                                    <p class="small"><i class="fa-solid fa-hourglass-end me-2"></i><?= date('d M Y, g:ia', strtotime($event['end_date'])); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="<?= $baseUrl; ?>events/view?id=<?= urlencode($event['id']); ?>" class="btn btn-sm btn-outline-primary">Learn more</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        <div>No upcoming events at the moment. Please check back soon.</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title mb-0">Latest Insights</h2>
                    <a href="<?= $baseUrl; ?>pages/blog" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-newspaper me-1"></i>View blog</a>
                </div>
                <?php if (!empty($latestPosts)): ?>
                    <?php foreach ($latestPosts as $post): ?>
                        <article class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><a class="text-decoration-none text-dark" href="<?= $baseUrl; ?>pages/blog?slug=<?= urlencode($post['slug']); ?>"><?= htmlspecialchars($post['title']); ?></a></h5>
                                <?php if (!empty($post['published_at'])): ?>
                                    <p class="small text-muted mb-2"><i class="fa-solid fa-calendar-day me-2"></i><?= date('d M Y', strtotime($post['published_at'])); ?></p>
                                <?php endif; ?>
                                <p class="card-text small mb-0"><?= htmlspecialchars($post['excerpt']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-secondary" role="alert">
                        <i class="fa-solid fa-info-circle me-2"></i>No published blog posts yet.
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <?php require __DIR__ . '/includes/sidebar.php'; ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fa-solid fa-message me-2 text-primary"></i>Stay Informed</h5>
                        <p class="small mb-3">Subscribe to receive updates on campaigns, events, and community highlights.</p>
                        <form>
                            <div class="mb-3">
                                <label for="newsletterEmail" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="newsletterEmail" placeholder="you@example.com" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        <h2 class="section-title">Ready to Lead Change?</h2>
        <p class="lead mb-4">Whether you are a member, aspirant, or administrator, POMS equips you with the tools to engage meaningfully in democratic processes.</p>
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="<?= $baseUrl; ?>auth/register" class="btn btn-success btn-lg"><i class="fa-solid fa-flag-checkered me-2"></i>Join as Member</a>
            <a href="<?= $baseUrl; ?>auth/register?type=aspirant" class="btn btn-outline-primary btn-lg"><i class="fa-solid fa-handshake-angle me-2"></i>Register as Aspirant</a>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
