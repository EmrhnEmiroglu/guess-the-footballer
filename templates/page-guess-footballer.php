<?php
/**
 * Template Name: Guess Footballer Template
 */

defined('ABSPATH') || exit;

get_header();
?>

<div id="gtf-game" class="gtf-game" data-max-attempts="5">
    <div class="gtf-card">
        <header class="gtf-header">
            <h1 class="gtf-title">Guess The Footballer</h1>
            <p class="gtf-subtitle">Bulanık fotoğrafa bak ve futbolcuyu bul.</p>
        </header>

        <section class="gtf-image-section">
            <div class="gtf-image-frame">
                <img id="gtf-player-image" class="gtf-player-image" src="" alt="" />
            </div>
        </section>

        <section class="gtf-attempts" aria-live="polite">
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <div class="gtf-attempt-row" data-attempt="<?php echo esc_attr($i); ?>">
                    <span class="gtf-attempt-label"><?php echo esc_html($i); ?>. Tahmin</span>
                    <div class="gtf-attempt-boxes"></div>
                </div>
            <?php endfor; ?>
        </section>

        <form id="gtf-guess-form" class="gtf-form" autocomplete="off">
            <input type="text" id="gtf-guess-input" class="gtf-input" placeholder="Futbolcu adını yaz" aria-label="Tahmin" />
            <button type="submit" class="gtf-button">Tahmin Et</button>
        </form>

        <div id="gtf-message" class="gtf-message" role="status"></div>

        <footer class="gtf-footer">
            <div class="gtf-streak">Streak: <span id="gtf-streak-count">0</span></div>
            <button type="button" id="gtf-new-game" class="gtf-button gtf-button--ghost">Yeni Oyun</button>
        </footer>
    </div>
</div>

<?php
get_footer();