<?php
                    if (isset($_SESSION['success'])) {
                        ?>
                        <span style="margin-bottom: 10px; color: green; font-weight: bolder;"><?php echo $_SESSION['success']; ?></span>
                        <?php
                    } 
                    $_SESSION['success'] = null;
                ?>
                <?php
                    if (isset($_SESSION['error'])) {
                        ?>
                        <span style="margin-bottom: 10px; color: red; font-weight: bolder;"><?php echo $_SESSION['error']; ?></span>
                        <?php
                    } 
                    $_SESSION['error'] = null;
                ?>