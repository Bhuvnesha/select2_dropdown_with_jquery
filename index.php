<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>



    <select name="channel-list" id="channel-list" class="form-control">
        <option value="">Select Channel</option>
        <option value="1">Integration & Configuration</option>
        <option value="2">DB Sync</option>
        <option value="3">USSD</option>
        <option value="4">Devops</option>
        <option value="5">Others</option>
        <option value="6">Project Management</option>
        <option value="7">Testing / QA</option>
        <option value="8">UI / UX</option>
        <option value="9">iOS</option>
        <option value="10">Andriod</option>
        <option value="11">Web (Internet Banking)</option>
        <option value="12">Web (Backend Admin)</option>
    </select>
    <button id="add-channel">Add</button>
    <div id="selected-channels"></div>

    <script>
    $(document).ready(function() {
        // Initialize Select2
        $('#channel-list').select2({
            placeholder: 'Select a channel'
        });

        // Track selected channels to prevent duplicates
        let selectedChannels = new Set();

        $('#add-channel').click(function() {
            const $select = $('#channel-list');
            const selectedOption = $select.find('option:selected');
            const channelId = selectedOption.val();
            const channelText = selectedOption.text();

            // Check if a channel is selected and not already added
            if (channelId && !selectedChannels.has(channelId)) {
                const channelDiv = `
                    <div class="channel-row" data-channel-id="${channelId}">
                        <input type="text" value="${channelText}" readonly>
                        <input type="number" value="0" min="0">
                        <button class="remove-channel">Remove</button>
                    </div>
                `;
                
                $('#selected-channels').append(channelDiv);
                selectedChannels.add(channelId);

                // Remove option from dropdown
                selectedOption.remove();
                $select.val('').trigger('change');
            }
        });

        // Remove channel functionality
        $(document).on('click', '.remove-channel', function() {
            const $row = $(this).closest('.channel-row');
            const channelId = $row.data('channel-id');
            const channelText = $row.find('input:first').val();

            // Add option back to dropdown
            $('#channel-list').append(`<option value="${channelId}">${channelText}</option>`);
            
            // Remove row and tracking
            $row.remove();
            selectedChannels.delete(channelId);
        });
    });
    </script>
</body>
</html>



<!-- Key features:

Select2 dropdown for enhanced selection
Dynamic addition of channels with number input
Prevents duplicate channel selections
Option to remove added channels
Restores removed channels back to dropdown -->