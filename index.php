<?php
require_once __DIR__ . '/config/config.php';
$settings = getSiteSettings($pdo);

$manifestoStmt = $pdo->query('SELECT title, summary, published_at FROM manifestoes ORDER BY published_at DESC LIMIT 3');
$manifestoes = $manifestoStmt->fetchAll();

$eventStmt = $pdo->query('SELECT title, event_date, venue FROM events WHERE status = "published" ORDER BY event_date ASC LIMIT 4');
$events = $eventStmt->fetchAll();

$postStmt = $pdo->query('SELECT title, slug, excerpt, published_at FROM posts WHERE status = "published" ORDER BY published_at DESC LIMIT 3');
$posts = $postStmt->fetchAll();

include __DIR__ . '/Includes/Header.php';
?>
<section class="hero-section text-center">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Empowering Democratic Participation</h1>
                <p class="lead mb-4">Join the Political Organisation Management System to mobilise communities, support aspirants, and build a stronger, more engaged democracy.</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a class="btn btn-primary btn-lg" href="/Auth/register"><i class="fa-solid fa-user-plus me-2"></i>Become a Member</a>
                    <a class="btn btn-outline-light btn-lg" href="#events"><i class="fa-solid fa-calendar-check me-2"></i>Upcoming Events</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-icon mb-3"><i class="fa-solid fa-users"></i></div>
                    <h5>Organise Supporters</h5>
                    <p class="text-muted">Manage member onboarding, communication, and mobilisation with ease.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-icon mb-3"><i class="fa-solid fa-user-tie"></i></div>
                    <h5>Empower Aspirants</h5>
                    <p class="text-muted">Provide aspirants with the tools to manage campaigns, events, and compliance.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="card-icon mb-3"><i class="fa-solid fa-chart-line"></i></div>
                    <h5>Data-Driven Decisions</h5>
                    <p class="text-muted">Gain insights through analytics, reporting, and real-time dashboards.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 bg-light" id="manifestoes">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Latest Manifestoes</h2>
            <a class="text-decoration-none" href="/Pages/manifestoes">View all</a>
        </div>
        <div class="row g-4">
            <?php foreach ($manifestoes as $manifesto): ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="fa-solid fa-scroll me-2"></i><?= htmlspecialchars($manifesto['title'], ENT_QUOTES); ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($manifesto['summary'], ENT_QUOTES); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-muted small">
                            <i class="fa-regular fa-calendar me-2"></i><?= date('d M Y', strtotime($manifesto['published_at'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($manifestoes)): ?>
                <div class="col-12">
                    <div class="alert alert-info"><i class="fa-solid fa-circle-info me-2"></i>No manifestoes yet. Stay tuned!</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="py-5" id="events">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Upcoming Events</h2>
            <a class="text-decoration-none" href="/Pages/events">View calendar</a>
        </div>
        <div class="row g-4">
            <?php foreach ($events as $event): ?>
                <div class="col-md-6 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa-solid fa-calendar-day me-2 text-primary"></i><?= htmlspecialchars($event['title'], ENT_QUOTES); ?></h5>
                            <p class="card-text text-muted mb-2"><i class="fa-regular fa-clock me-2"></i><?= date('d M Y, h:i A', strtotime($event['event_date'])); ?></p>
                            <p class="card-text text-muted"><i class="fa-solid fa-location-dot me-2"></i><?= htmlspecialchars($event['venue'] ?? 'Venue to be announced', ENT_QUOTES); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($events)): ?>
                <div class="col-12">
                    <div class="alert alert-warning"><i class="fa-solid fa-bell me-2"></i>No upcoming events currently scheduled.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">From the Blog</h2>
            <a class="text-decoration-none" href="/Pages/blog">Read more</a>
        </div>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post['title'], ENT_QUOTES); ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($post['excerpt'], ENT_QUOTES); ?></p>
                            <a class="stretched-link" href="/Pages/blog/<?= htmlspecialchars($post['slug'], ENT_QUOTES); ?>">Read Story</a>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-muted small">
                            <i class="fa-regular fa-calendar me-2"></i><?= date('d M Y', strtotime($post['published_at'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($posts)): ?>
                <div class="col-12">
                    <div class="alert alert-info"><i class="fa-solid fa-circle-info me-2"></i>No blog posts available yet.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h2 class="section-title">Ready to make a difference?</h2>
                <p class="lead">Register today to join our growing network of civic-minded members and aspirants dedicated to strengthening democracy.</p>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="you@example.com">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Area of Interest</label>
                                <select class="form-select">
                                    <option selected>Member mobilisation</option>
                                    <option>Aspirant support</option>
                                    <option>Volunteer</option>
                                    <option>Donor</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Submit Interest</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/Includes/Footer.php'; ?>
