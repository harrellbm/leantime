<?php
    foreach ($__data as $var => $val) $$var = $val; // necessary for blade refactor
    $ticket = $tpl->get('ticket');
    $remainingHours = $tpl->get('remainingHours');
    $statusLabels  = $tpl->get('statusLabels');
    $ticketTypes = $tpl->get('ticketTypes');

?>
<input type="hidden" value="<?php $tpl->e($ticket->id); ?>" name="id" autocomplete="off" readonly/>

<div class="row-fluid">
    <div class="span8">
        <div class="row-fluid marginBottom">
            <div class="span12">

                <div class="form-group">
                        <input type="text" value="<?php $tpl->e($ticket->headline); ?>" name="headline" class="main-title-input" autocomplete="off" style="width:99%;" placeholder="<?=$tpl->__('input.placeholders.enter_title_of_todo')?>"/>
                </div>
                <div class="form-group">
                    <input type="text" value="<?php $tpl->e($ticket->tags); ?>" name="tags" id="tags" />
                </div>

                <div class="viewDescription mce-content-body">
                    <?=$tpl->__("label.description") ?><br /><br />
                    <?php echo $tpl->escapeMinimal($ticket->description); ?>
                </div>
                <div class="form-group" id="descriptionEditor" style="display:none;">
                    <textarea name="description" rows="10" cols="80" id="ticketDescription"
                              class="complexEditor"><?php echo htmlentities($ticket->description); ?></textarea><br/>
                </div>
                <input type="hidden" name="acceptanceCriteria" value=""/>

            </div>
        </div>
        <div class="row-fluid">
            <input type="hidden" name="saveTicket" value="1" />
            <input type="hidden" id="saveAndCloseButton" name="saveAndCloseTicket" value="0" />


            <input type="submit" name="saveTicket" value="<?php echo $tpl->__('buttons.save'); ?>"/>
            <input type="submit" name="saveAndCloseTicket" onclick="jQuery('#saveAndCloseButton').val('1');" value="<?php echo $tpl->__('buttons.save_and_close'); ?>"/>

        </div>

        <?php if ($ticket->id) {?>
        <br />
            <hr />

            <h4 class="widgettitle title-light"><span
                    class="fa-solid fa-comments"></span><?php echo $tpl->__('subtitles.discussion'); ?></h4>

        <div class="row-fluid">
        <form method="post" action="<?=BASE_URL ?>/tickets/showTicket/<?php echo $ticket->id; ?>" class="ticketModal">
            <input type="hidden" name="comment" value="1" />
            <?php
            $tpl->assign('formUrl', "" . BASE_URL . "/tickets/showTicket/" . $ticket->id . "");

            $tpl->displaySubmodule('comments-generalComment') ;
            ?>
        </form>
        </div>
        <?php } ?>
    </div>
    <div class="span4">
        <div class="row-fluid marginBottom">
            <div class="span12">
                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.related_to'); ?></label>
                    <div class="span6">
                        <div class="form-group">
                            <select  name="dependingTicketId"  class="span11" >
                                <option value=""><?php echo $tpl->__('label.not_related'); ?></option>
                                <?php foreach ($tpl->get('ticketParents') as $ticketRow) {
                                    ?>
                                    <?php echo"<option value='" . $ticketRow->id . "'";

                                    if (($ticket->dependingTicketId == $ticketRow->id)) {
                                        echo" selected='selected' ";
                                    }

                                    echo">" . $tpl->escape($ticketRow->headline) . "</option>"; ?>

                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.todo_status'); ?></label>
                    <div class="span6">
                        <select
                            id="status-select"
                            class="span11"
                            name="status"
                            data-placeholder="<?php echo isset($ticket->status) ? $statusLabels[$ticket->status]["name"] ?? '' : ''; ?>"
                        >
                            <?php foreach ($statusLabels as $key => $label) {?>
                                <option value="<?php echo $key; ?>"
                                    <?php if ($ticket->status == $key) {
                                        echo "selected='selected'";
                                    } ?>
                                ><?php echo $tpl->escape($label["name"]); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.todo_type'); ?></label>
                    <div class="span6">
                        <select id='type' name='type' class="span11">
                            <?php foreach ($ticketTypes as $types) {
                                echo "<option value='" . strtolower($types) . "' ";
                                if (strtolower($types) == strtolower($ticket->type)) {
                                    echo "selected='selected'";
                                }

                                echo ">" . $tpl->__("label." . strtolower($types)) . "</option>";
                            } ?>
                        </select><br/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.priority'); ?></label>
                    <div class="span6">
                        <select id='priority' name='priority' class="span11">
                            <option value=""><?php echo $tpl->__('label.priority_not_defined'); ?></option>
                            <?php foreach ($tpl->get('priorities') as $priorityKey => $priorityValue) {
                                echo "<option value='" . $priorityKey . "' ";
                                if ($priorityKey == $ticket->priority) {
                                    echo "selected='selected'";
                                }
                                echo ">" . $priorityValue . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.effort'); ?></label>
                    <div class="span6">
                        <select id='storypoints' name='storypoints' class="span11">
                            <option value=""><?php echo $tpl->__('label.effort_not_defined'); ?></option>
                            <?php foreach ($tpl->get('efforts') as $effortKey => $effortValue) {
                                echo "<option value='" . $effortKey . "' ";
                                if ($effortKey == $ticket->storypoints) {
                                    echo "selected='selected'";
                                }
                                echo ">" . $effortValue . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid marginBottom">
            <div class="span12">

                <h4 class="widgettitle title-light"><span
                            class="fa fa-folder-open"></span><?php echo $tpl->__('subtitles.organization'); ?></h4>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.milestone'); ?></label>
                    <div class="span6">
                        <div class="form-group">
                            <select  name="milestoneid"  class="span11" >
                                <option value=""><?php echo $tpl->__('label.not_assigned_to_milestone'); ?></option>
                                <?php foreach ($tpl->get('milestones') as $milestoneRow) {     ?>
                                    <?php echo"<option value='" . $milestoneRow->id . "'";

                                    if (($ticket->milestoneid == $milestoneRow->id)) {
                                        echo" selected='selected' ";
                                    }

                                    echo">" . $tpl->escape($milestoneRow->headline) . "</option>"; ?>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.sprint'); ?></label>
                    <div class="span6">

                        <select id="sprint-select" class="span11" name="sprint"
                                data-placeholder="<?php echo $ticket->sprint ?>">
                            <option value=""><?php echo $tpl->__('label.not_assigned_to_sprint'); ?></option>
                            <?php
                            if ($tpl->get('sprints')) {
                                foreach ($tpl->get('sprints') as $sprintRow) { ?>
                                    <option value="<?php echo $sprintRow->id; ?>"
                                        <?php if ($ticket->sprint == $sprintRow->id) {
                                            echo "selected='selected'";
                                        } ?>
                                    ><?php $tpl->e($sprintRow->name); ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="row-fluid marginBottom">
            <div class="span12">

                <h4 class="widgettitle title-light"><span
                            class="fa fa-group"></span><?php echo $tpl->__('subtitle.people'); ?></h4>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.author'); ?></label>
                    <div class="span6">
                        <input type="text" disabled="disabled" style="width:175px;"
                               value="<?php $tpl->e($ticket->userFirstname); ?> <?php $tpl->e($ticket->userLastname); ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.editor'); ?></label>
                    <div class="span6">

                        <select data-placeholder="<?php echo $tpl->__('label.filter_by_user'); ?>" style="width:175px;"
                                name="editorId" id="editorId" class="user-select span11">
                            <option value=""><?php echo $tpl->__('label.not_assigned_to_user'); ?></option>
                            <?php foreach ($tpl->get('users') as $userRow) { ?>
                                <?php echo "<option value='" . $userRow["id"] . "'";

                                if ($ticket->editorId == $userRow["id"]) {
                                    echo " selected='selected' ";
                                }

                                echo ">" . $tpl->escape($userRow["firstname"] . " " . $userRow["lastname"]) . "</option>"; ?>

                            <?php } ?>
                        </select><br />
                        <?php if ($login::userIsAtLeast($roles::$editor)) {  ?>
                            <small style="margin-top:-5px; display:block"><a href="javascript:void(0);" onclick="jQuery('#editorId').val(<?php echo $_SESSION['userdata']['id']; ?>).trigger('chosen:updated');"><?php echo $tpl->__('label.assign_to_me'); ?></a></small>
                        <?php } ?>
                    </div>
                </div>


    </div>
</div>
        <div class="row-fluid marginBottom">
            <div class="span12">
                <h4 class="widgettitle title-light"><span
                            class="fa fa-calendar"></span><?php echo $tpl->__('subtitles.dates'); ?></h4>
                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.ticket_date'); ?></label>
                    <div class="span6">

                        <input type="text" class="dates" style="width:90px;" id="submittedDate" disabled="disabled"
                               value="<?php echo $ticket->date; ?>" name="date"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.due_date'); ?></label>
                    <div class="span6">
                        <input type="text" class="dates" style="width:90px;" id="deadline" autocomplete="off"
                               value="<?php echo $ticket->dateToFinish; ?>"
                               name="dateToFinish" placeholder="<?=$tpl->__('language.dateformat') ?>"/>

                        <input type="time" class="timepicker" style="width:120px;" id="dueTime" autocomplete="off"
                               value="<?php echo $ticket->timeToFinish; ?>"
                               name="timeToFinish"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.working_date_from'); ?></label>
                    <div class="span6">
                        <input type="text" class="dates" style="width:90px;" name="editFrom" autocomplete="off"
                               value="<?php echo $ticket->editFrom; ?>" placeholder="<?=$tpl->__('language.dateformat') ?>"/>
                        <input type="time" class="timepicker" style="width:120px;" id="timeFrom" autocomplete="off"
                               value="<?php echo $ticket->timeFrom; ?>"
                               name="timeFrom"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.working_date_to'); ?></label>
                    <div class="span6">
                        <input type="text" class="dates" style="width:90px;" name="editTo" autocomplete="off"
                               value="<?php echo $ticket->editTo; ?>" placeholder="<?=$tpl->__('language.dateformat') ?>"/>
                        <input type="time" class="timepicker" style="width:120px;" id="timeTo" autocomplete="off"
                               value="<?php echo $ticket->timeTo; ?>"
                               name="timeTo"/>
                    </div>
                </div>

            </div>
        </div>
        <div class="row-fluid marginBottom">
            <div class="span12">
                <h4 class="widgettitle title-light"><span
                            class="fa-regular fa-clock"></span><?php echo $tpl->__('subtitle.time_tracking'); ?></h4>
                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.planned_hours'); ?></label>
                    <div class="span6">
                        <input type="text" value="<?php $tpl->e($ticket->planHours); ?>" name="planHours" style="width:90px;"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.estimated_hours_remaining'); ?></label>
                    <div class="span6">
                        <input type="text" value="<?php $tpl->e($ticket->hourRemaining); ?>" name="hourRemaining" style="width:90px;"/>
                        <a href="javascript:void(0)" class="infoToolTip" data-placement="left" data-toggle="tooltip" data-original-title="<?php echo $tpl->__('tooltip.how_many_hours_remaining'); ?>">
                            &nbsp;<i class="fa fa-question-circle"></i>&nbsp;</a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.booked_hours'); ?></label>
                    <div class="span6">
                        <input type="text" disabled="disabled"
                               value="<?php echo $tpl->get('timesheetsAllHours'); ?>" style="width:90px;"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="span4 control-label"><?php echo $tpl->__('label.actual_hours_remaining'); ?></label>
                    <div class="span6">
                        <input type="text" disabled="disabled" value="<?php echo $remainingHours; ?>" style="width:90px;"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    leantime.generalController.initComplexEditor();

    jQuery(document).ready(function(){
        jQuery("select").chosen();
    });


    jQuery(".viewDescription").click(function(e){

        if(!jQuery(e.target).is("a")) {
            e.stopPropagation();
            jQuery(this).hide();
            jQuery('#descriptionEditor').show();
        }
    });

    Prism.highlightAll();

</script>

