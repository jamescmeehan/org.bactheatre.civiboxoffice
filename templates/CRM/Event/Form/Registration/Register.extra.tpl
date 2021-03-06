{if $seatMap}
  <div id="seat-map-staging-area" style="display: none;">
    <div id="seat-map-section">
      <div id="seat-map-selector-wrapper" style="display: none;">
        <div class="label" style="float: left; font-size: .95em; padding: 5px; text-align: left; width: 150px;">
          Event Seating
        </div>
        <select id="seat-map-selector">
          <option value="subscription">Flex Pass</option>
          <option value="general_admission">General Admission</option>
        </select>
      </div>
      <div style="float: clear;">
        &nbsp;
      </div>
      <div id="seat-map">
        {$seatMap}
      </div>
    </div>
  </div>
{/if}
{if $add_subscription_section}
  <div id="subscription-section-staging-area" style="display: none;">
    <div id="subscription-section" class="crm-section subscription-section">
      <fieldset>
	<legend>Flex Pass</legend>
	<div style="margin: 0 0 5px 5px;">
	  If you have a Flex Pass, please enter your email here to reserve
	  seats.
	</div>
	<div class="label">
	  <label for="subscription_email_address">Email Address</label>
	</div>
	<div class="content">
	  <input type="text" id="subscription_email_address" name="subscription_email_address" value="{$subscription_email_address}">
          <input type="hidden" id="subscription_participant_id" name="subscription_participant_id">
          {literal}
            <style type="text/css">
              #crm-container input[type=button].fake-button:active
              {
                background: #70716B url(/sites/all/modules/civicrm/i/crm-button-bg.gif/i/crm-button-bg.gif);
                background-position: 0px -25px;
              }
            </style>
          {/literal}
          <input class="fake-button" type="button" value="Submit">
	</div>
	<div id="subscription-choice-area" class="content">
	</div>
	<div id="subscription-message-area" class="content">
	  <div id="subscription-messages">
	  </div>
	</div>
      </div>
    </fieldset>
  </div>
  <script type="text/javascript">
    var event_id = {$event_id};
  </script>
{/if}
