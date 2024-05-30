<h4 class="mt-5">Activity</h4>
            <div class="card mt-5">
                <div class="card-body">

                    <div class="timeline timeline-2">
                        <div class="timeline-bar"></div>

                        <?php
                        foreach ($log_survey as $row) {
                        ?>
                        <div class="timeline-item">
                            <span class="timeline-badge"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                    <?php echo $row->log_value ?>
                                </span>
                                <span class="text-muted text-right">
                                    {{ date("d-m-Y", strtotime($row->log_time)) }}</span>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <!-- <div class="timeline-item">
                            <span class="timeline-badge"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                    Survey has created.
                                </span>
                                <span class="text-muted text-right">2 days ago</span>
                            </div>
                        </div> -->


                    </div>

                </div>
            </div>