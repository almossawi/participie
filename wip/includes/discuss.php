<!-- for-argument box start -->
				<div class="discuss_increase corner">
					<span class="arguments_for_title">Arguments for increasing</span><!--<img src="../images/arrow_up.png" alt="Vote up" title="Vote up" style="padding-left:10px" />-->
					<div id="f<?php echo $slice; ?>_discuss_arguments_for" class="discuss_arguments_box_content">
						<!-- 1st argument for -->
						<?php if(isset($data[0])) { 
							if($data[0]['evidence_article'] == "")  { $no_evidence_article = true; $evidence_article = "no evidence article provided"; }
							else { $no_evidence_article = false; $evidence_article = "<a href='{$data[0]['evidence_article']}' target='_blank'>evidence article</a>"; }
		
							if($no_evidence_article) $no_evidence_article_formatting = "style='color:#717171'";
							else { $no_evidence_article_formatting = ""; }
						?>
						<div class='discuss_statement discuss_statement_main_page' <?php echo $no_evidence_article_formatting; ?>>
							<div style="width:93%"><?php echo $data[0]['statement']; ?>
							<br /><span class="discuss_public_opinion"><i>- <?php echo $data[0]['author']; ?> (<?php echo $data[0]['city']; ?>, <?php echo $data[0]['state']; ?>)</i></span>
							</div>
							<a href="#" onclick="return false"><img src="../images/arrow_up.png" alt="Vote up" title="Vote up" class="vote_statement_up_arrow" id="u<?php echo $data[0]['cpd_id']; ?>" /></a><a href="#" onclick="return false"><img src="../images/arrow_down.png" alt="Vote down" title="Vote down" class="vote_statement_down_arrow" id="d<?php echo $data[0]['cpd_id']; ?>" /></a>
						</div>
						<div class="discuss_comment_toolbox" <?php echo $no_evidence_article_formatting; ?>><?php echo $evidence_article; ?> &middot; <a href="#" onclick="return false" id="f<?php echo $data[0]['cpd_id']; ?>" class="flag_the_mofo">flag as inappropriate</a> <!--&middot; <a href="#" onclick="return false" id="f<?php echo $data[0]['cpd_id']; ?>" class="agree_disagree">agree/disagree?</a> &middot;--> <img src="../images/arrow_up.png" alt="up votes" title="p votes" style="width:10px" /> <span id="upvotes_<?php echo $data[0]['cpd_id']; ?>"><?php echo $data[0]['up_votes']; ?></span> &nbsp;<img src="../images/arrow_down.png" alt="down votes" title="down votes" style="width:10px" /> <span id="downvotes_<?php echo $data[0]['cpd_id']; ?>"><?php echo $data[0]['down_votes']; ?></span></div>
						<div class="discuss_public_opinion_container" <?php echo $no_evidence_article_formatting; ?>>Public opinion: &nbsp;&nbsp;&nbsp;<img src="../images/plus.png" /><a href="#" id="f<?php echo $data[0]['cpd_id']; ?>" class="agree_disagree" onclick="return false"><span style="font-style:italic;font-size:11px;color:#2e52a4">add yours</span></a>
						<?php if($data[0]['opinion_author'] == "") {?>
								<div class="discuss_public_opinion"><i>none yet</i></div>
							<?php } else { ?>
							<div id="f<?php echo $slice; ?>_one_of_the_public_opinions" class="discuss_public_opinion"><i><?php echo $data[0]['opinion_author']; ?> (<?php echo $data[0]['opinion_city']; ?>, <?php echo $data[0]['opinion_state']; ?>):</i> <?php echo $data[0]['public_opinion']; ?></div>
							<?php } ?>
						</div>
						<?php } else {
							echo "<div style='padding-top:150px;width:100%;text-align:center;font-style:italic;font-size:85%'>none yet</div>";
						} ?>
						<!-- end 1st argument for -->
						<!-- 2nd argument for -->
						<?php if(isset($data[1])) {
						if($data[1]['evidence_article'] == "")  { $no_evidence_article = true; $evidence_article = "no evidence article provided"; }
							else { $no_evidence_article = false; $evidence_article = "<a href='{$data[1]['evidence_article']}' target='_blank'>evidence article</a>"; }
		
							if($no_evidence_article) $no_evidence_article_formatting = "style='color:#717171'";
							else { $no_evidence_article_formatting = ""; }
						?>
						<div class='discuss_statement discuss_statement_main_page' <?php echo $no_evidence_article_formatting; ?>>
							<div style="width:93%"><?php echo $data[1]['statement']; ?>
							<br /><span class="discuss_public_opinion"><i>- <?php echo $data[1]['author']; ?> (<?php echo $data[1]['city']; ?>, <?php echo $data[1]['state']; ?>)</i></span>
							</div>
							<a href="#" onclick="return false"><img src="../images/arrow_up.png" alt="Vote up" title="Vote up" class="vote_statement_up_arrow" id="u<?php echo $data[1]['cpd_id']; ?>" /></a><a href="#" onclick="return false"><img src="../images/arrow_down.png" alt="Vote down" title="Vote down" class="vote_statement_down_arrow" id="d<?php echo $data[1]['cpd_id']; ?>" /></a>
						</div>
						<div class="discuss_comment_toolbox" <?php echo $no_evidence_article_formatting; ?>><?php echo $evidence_article; ?> &middot; <a href="#" onclick="return false" id="f<?php echo $data[1]['cpd_id']; ?>" class="flag_the_mofo">flag as inappropriate</a> &middot; <!--<a href="#" onclick="return false" id="f<?php echo $data[1]['cpd_id']; ?>" class="agree_disagree">agree/disagree?</a>--> &middot; <img src="../images/arrow_up.png" alt="up votes" title="up votes" style="width:10px" /> <span id="upvotes_<?php echo $data[1]['cpd_id']; ?>"><?php echo $data[1]['up_votes']; ?></span> &nbsp;<img src="../images/arrow_down.png" alt="" title="" style="width:10px" /> <span id="downvotes_<?php echo $data[1]['cpd_id']; ?>"><?php echo $data[1]['down_votes']; ?></span></div>
						<div class="discuss_public_opinion_container" <?php echo $no_evidence_article_formatting; ?>>Public opinion: &nbsp;&nbsp;&nbsp;<img src="../images/plus.png" /><a href="#" class="agree_disagree" id="f<?php echo $data[1]['cpd_id']; ?>" onclick="return false"><span style="font-style:italic;font-size:11px;color:#2e52a4">add yours</span></a>
							<?php if($data[1]['opinion_author'] == "") {?>
								<div class="discuss_public_opinion"><i>none yet</i></div>
							<?php } else { ?>
							<div id="f<?php echo $slice; ?>_one_of_the_public_opinions" class="discuss_public_opinion"><i><?php echo $data[1]['opinion_author']; ?> (<?php echo $data[1]['opinion_city']; ?>, <?php echo $data[1]['opinion_state']; ?>):</i> <?php echo $data[1]['public_opinion']; ?></div>
							<?php } ?>
						</div>
						<!-- end 2nd argument for -->
						<?php } else {
							//nothing if we only have one statement		
						} ?>
					</div>
					<div class="edit"><a href="#" onclick="return false" id="ef<?php echo $slice; ?>" class="add_to_the_argument">add</a></div>
					<div class="seemore"><a href="#" onclick="return false" id="sf<?php echo $slice; ?>" class="seemore_link">see more</a></div>
				</div>
				<!-- for-argument box end -->
				<!-- against-argument box start -->
				<div class="discuss_decrease corner">
					<span class="arguments_against_title">Arguments for decreasing</span><!--<img src="../images/arrow_down.png" alt="" title="" style="padding-left:10px" />-->
					<div id="f<?php echo $slice; ?>_discuss_arguments_against" class="discuss_arguments_box_content">
						<!-- 1st argument against -->
						<?php if(isset($data[2])) {
							if($data[2]['evidence_article'] == "")  { $no_evidence_article = true; $evidence_article = "no evidence article provided"; }
							else { $no_evidence_article = false; $evidence_article = "<a href='{$data[2]['evidence_article']}' target='_blank'>evidence article</a>"; }
		
							if($no_evidence_article) $no_evidence_article_formatting = "style='color:#717171'";
							else { $no_evidence_article_formatting = ""; }
						?>
						<div class='discuss_statement discuss_statement_main_page' <?php echo $no_evidence_article_formatting; ?>>
							<div style="width:93%"><?php echo $data[2]['statement']; ?>
							<br /><span class="discuss_public_opinion"><i>- <?php echo $data[2]['author']; ?> (<?php echo $data[2]['city']; ?>, <?php echo $data[2]['state']; ?>)</i></span>
							</div>
							<a href="#" onclick="return false"><img src="../images/arrow_up.png" alt="Vote up" title="Vote up" class="vote_statement_up_arrow" id="u<?php echo $data[2]['cpd_id']; ?>" /></a><a href="#" onclick="return false"><img src="../images/arrow_down.png" alt="Vote down" title="Vote down" class="vote_statement_down_arrow" id="d<?php echo $data[2]['cpd_id']; ?>" /></a>
						</div>
						<div class="discuss_comment_toolbox" <?php echo $no_evidence_article_formatting; ?>><?php echo $evidence_article; ?> &middot; <a href="#" onclick="return false" id="f<?php echo $data[2]['cpd_id']; ?>" class="flag_the_mofo">flag as inappropriate</a> <!--&middot; <a href="#" onclick="return false" id="f<?php echo $data[2]['cpd_id']; ?>" class="agree_disagree">agree/disagree?</a>--> &middot; <img src="../images/arrow_up.png" alt="up votes" title="up votes" style="width:10px" /> <span id="upvotes_<?php echo $data[2]['cpd_id']; ?>"><?php echo $data[2]['up_votes']; ?></span> &nbsp;<img src="../images/arrow_down.png" alt="down votes" title="down votes" style="width:10px" /> <span id="downvotes_<?php echo $data[2]['cpd_id']; ?>"><?php echo $data[2]['down_votes']; ?></span></div>
						<div class="discuss_public_opinion_container" <?php echo $no_evidence_article_formatting; ?>>Public opinion: &nbsp;&nbsp;&nbsp;<img src="../images/plus.png" /><a href="#" id="f<?php echo $data[2]['cpd_id']; ?>" class="agree_disagree" onclick="return false"><span style="font-style:italic;font-size:11px;color:#2e52a4">add yours</span></a>
							<?php if($data[2]['opinion_author'] == "") {?>
								<div class="discuss_public_opinion"><i>none yet</i></div>
							<?php } else { ?>
							<div id="f<?php echo $slice; ?>_one_of_the_public_opinions" class="discuss_public_opinion"><i><?php echo $data[2]['opinion_author']; ?> (<?php echo $data[2]['opinion_city']; ?>, <?php echo $data[2]['opinion_state']; ?>):</i> <?php echo $data[2]['public_opinion']; ?></div>
							<?php } ?>
						</div>
						<!-- end 1st argument against -->
						<?php } else {
							echo "<div style='padding-top:150px;width:100%;text-align:center;font-style:italic;font-size:85%'>none yet</div>";
						} ?>
						<!-- 2nd argument against -->
						<?php if(isset($data[3])) {
							if($data[3]['evidence_article'] == "")  { $no_evidence_article = true; $evidence_article = "no evidence article provided"; }
							else { $no_evidence_article = false; $evidence_article = "<a href='{$data[3]['evidence_article']}' target='_blank'>evidence article</a>"; }
		
							if($no_evidence_article) $no_evidence_article_formatting = "style='color:#717171'";
							else { $no_evidence_article_formatting = ""; }
						?>
						<div class='discuss_statement discuss_statement_main_page' <?php echo $no_evidence_article_formatting; ?>>
							<div style="width:93%"><?php echo $data[3]['statement']; ?>
							<br /><span class="discuss_public_opinion"><i>- <?php echo $data[3]['author']; ?> (<?php echo $data[3]['city']; ?>, <?php echo $data[3]['state']; ?>)</i></span>
							</div>
							<a href="#" onclick="return false"><img src="../images/arrow_up.png" alt="Vote up" title="Vote up" class="vote_statement_up_arrow" id="u<?php echo $data[3]['cpd_id']; ?>" /></a><a href="#" onclick="return false"><img src="../images/arrow_down.png" alt="Vote down" title="Vote down" class="vote_statement_down_arrow" id="d<?php echo $data[3]['cpd_id']; ?>" /></a>
						</div>
						<div class="discuss_comment_toolbox" <?php echo $no_evidence_article_formatting; ?>><?php echo $evidence_article; ?> &middot; <a href="#" onclick="return false" id="f<?php echo $data[3]['cpd_id']; ?>" class="flag_the_mofo">flag as inappropriate</a> <!--&middot; <a href="#" onclick="return false" id="f<?php echo $data[3]['cpd_id']; ?>" class="agree_disagree">agree/disagree?</a> &middot;--> <img src="../images/arrow_up.png" alt="up votes" title="up votes" style="width:10px" /> <span id="upvotes_<?php echo $data[3]['cpd_id']; ?>"><?php echo $data[3]['up_votes']; ?></span> &nbsp;<img src="../images/arrow_down.png" alt="down votes" title="down votes" style="width:10px" /> <span id="downvotes_<?php echo $data[3]['cpd_id']; ?>"><?php echo $data[3]['down_votes']; ?></span></div>
						<div class="discuss_public_opinion_container" <?php echo $no_evidence_article_formatting; ?>>Public opinion: &nbsp;&nbsp;&nbsp;<img src="../images/plus.png" /><a href="#" id="f<?php echo $data[3]['cpd_id']; ?>" class="agree_disagree" onclick="return false"><span style="font-style:italic;font-size:11px;color:#2e52a4">add yours</span></a>
							<?php if($data[3]['opinion_author'] == "") {?>
								<div class="discuss_public_opinion"><i>none yet</i></div>
							<?php } else { ?>
							<div id="f<?php echo $slice; ?>_one_of_the_public_opinions" class="discuss_public_opinion"><i><?php echo $data[3]['opinion_author']; ?> (<?php echo $data[3]['opinion_city']; ?>, <?php echo $data[3]['opinion_state']; ?>):</i> <?php echo $data[3]['public_opinion']; ?></div>
							<?php } ?>
						</div>
						<!-- end 2nd argument against -->
						<?php } else {
							//nothing if we only have one statement		
						} ?>
					</div>
					<div class="edit"><a href="#" onclick="return false" id="ea<?php echo $slice; ?>" class="add_to_the_argument">add</a></div>
					<div class="seemore"><a href="#" onclick="return false" id="sa<?php echo $slice; ?>" class="seemore_link">see more</a></div>
				</div>
				<!-- against-argument box end -->