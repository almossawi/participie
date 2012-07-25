				<!-- for-argument box start -->
				<div class="discuss_increase corner">
					<span class="arguments_for_title">Arguments for increasing</span><!--<img src="../images/arrow_up.png" alt="Vote up" title="Vote up" style="padding-left:10px" />-->
					<div id="f<?php echo $slice; ?>_discuss_arguments_for" class="discuss_arguments_box_content">
					<?php
						//show "for" arguments
						showDiscussionArguments($data_for);
					?>
					</div>
					<div class="edit"><a href="#" onclick="return false" id="ef<?php echo $slice; ?>" class="add_to_the_argument">add</a></div>
					<div class="seemore"><a href="#" onclick="return false" id="sf<?php echo $slice; ?>" class="seemore_link">see more</a></div>
				</div>
				<!-- for-argument box end -->
				
				<!-- against-argument box start -->
				<div class="discuss_decrease corner">
					<span class="arguments_against_title">Arguments for decreasing</span><!--<img src="../images/arrow_down.png" alt="" title="" style="padding-left:10px" />-->
					<div id="f<?php echo $slice; ?>_discuss_arguments_against" class="discuss_arguments_box_content">
					<?php
						//show "against" arguments
						showDiscussionArguments($data_against);
					?>
					</div>
					<div class="edit"><a href="#" onclick="return false" id="ea<?php echo $slice; ?>" class="add_to_the_argument">add</a></div>
					<div class="seemore"><a href="#" onclick="return false" id="sa<?php echo $slice; ?>" class="seemore_link">see more</a></div>
				</div>
				<!-- against-argument box end -->