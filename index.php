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
    <div>
        <strong>Total: </strong>
        <input type="number" id="total-sum" value="0" readonly>
    </div>

    <script>
    $(document).ready(function() {
        $('#channel-list').select2({
            placeholder: 'Select a channel'
        });

        let selectedChannels = new Set();

        function updateTotal() {
            let total = 0;
            $('.channel-row input[type="number"]').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#total-sum').val(total);
        }

        $('#add-channel').click(function() {
            const $select = $('#channel-list');
            const selectedOption = $select.find('option:selected');
            const channelId = selectedOption.val();
            const channelText = selectedOption.text();

            if (channelId && !selectedChannels.has(channelId)) {
                const channelDiv = `
                    <div class="channel-row" data-channel-id="${channelId}">
                        <input type="text" value="${channelText}" readonly>
                        <input type="number" value="0" min="0" class="channel-input">
                        <button class="remove-channel">Remove</button>
                    </div>
                `;
                
                $('#selected-channels').append(channelDiv);
                selectedChannels.add(channelId);

                // Bind input change event to update total
                $('.channel-row:last .channel-input').on('input', updateTotal);

                selectedOption.remove();
                $select.val('').trigger('change');
            }
        });

        $(document).on('click', '.remove-channel', function() {
            const $row = $(this).closest('.channel-row');
            const channelId = $row.data('channel-id');
            const channelText = $row.find('input:first').val();

            $('#channel-list').append(`<option value="${channelId}">${channelText}</option>`);
            
            $row.remove();
            selectedChannels.delete(channelId);
            updateTotal();
        });
    });
    </script>
</body>
</html>