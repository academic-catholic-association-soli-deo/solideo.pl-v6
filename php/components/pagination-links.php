<div class="row">
    <div class="col-md-12 center">
        <nav class="pagination-container" aria-label="Strony">
            <ul class="pagination">
                <?php if ($website['paginator']->hasPrevPage()): ?>
                    <li>
                        <a href="<?php echo $website['paginator']->getPrevLink() ?>" aria-label="Poprzednia strona">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="disabled">
                        <a aria-label="Poprzednia strona">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php
                for ($i = 1; $i <= $website['paginator']->getNumOfPages(); $i++) {
                    echo '<li ' . ($i == $website['paginator']->getCurrentPage() ? 'class="active"' : '') . '>';
                    echo '<a href="' . $website['paginator']->getPageLink($i) . '">' . $i . '</a>';
                    echo '</li>';
                }
                ?>

                <?php if ($website['paginator']->hasNextPage()): ?>
                    <li>
                        <a href="<?php echo $website['paginator']->getNextLink() ?>" aria-label="Następna strona">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="disabled">
                        <a aria-label="Następna strona">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>