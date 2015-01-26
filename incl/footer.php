<footer class="footer-container">
    <div class="grid_16 footer">
        <div class="grid_5 alpha push_1">
            <h4>Kontakta Ljungbys Begravningsmuseum</h4>
            <address>Box 4
                <br>
                341 21, Ljungby
                <br>
                Tel: 0372 - 671 10
                <br>
                Email: <a href="mailto:ljungby.pastorat@svenskakyrkan.se">ljungby.pastorat@svenskakyrkan.se</a>
                <br>
                <br>
                Måndag till fredag: 9.00 - 12.00
            </address>
            <p>Designad av <a href="https://www.linkedin.com/pub/daniel-b%C3%A4ckstr%C3%B6m/90/b52/b02">Daniel Bäckström (Bex)</a></p>
            <?php if(isset($pageTimeGeneration)) : ?>
                <p>Page generated in <?php echo round(microtime(true)-$pageTimeGeneration, 5); ?> seconds</p>
            <?php endif; ?>
        </div>
        <div class="grid_10 push_1 omega">
            <div class="grid_2 push_6 omega">
                <dl>
                    <dt>Admin</dt>
                    <dd><a href="http://validator.w3.org/check/referer">HTML5 validation</a></dd>
                    <dd><a href="http://jigsaw.w3.org/css-validator/check/referer">CSS validation</a></dd>
                    <dd><a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS3 validation</a></dd>
                    <dd><a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn validation</a></dd>
                    <dd><a href="http://validator.w3.org/i18n-checker/check?uri=<?php echo getCurrentUrl(); ?>">i18n validation</a></dd>
                    <dd><a href="http://validator.w3.org/checklink?uri=<?php echo getCurrentUrl(); ?>">Links validation</a></dd>
                    <dd><a href="viewsource.php">Källkod</a></dd>
                    <dd><?php echo userLoginMenu(); ?></dd>
                </dl>
            </div>
        </div>
    </div>
</footer>
</div><!-- .wrapper -->


</body>
</html>