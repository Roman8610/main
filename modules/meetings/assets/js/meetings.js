$(document).ready(function () {
    // Добавление новой строки
    $('#add-row-btn').off('click').on('click', function (e) {
        e.preventDefault();
        var $firstRow = $('.departments-directions-row').first();
        var $newRow = $firstRow.clone();
        
        // Очищаем поля (ищем input внутри div-обёрток)
        $newRow.find('.department-input input').val('');
        $newRow.find('.direction-input input').val('');
        
        // Показываем кнопку удаления у новой строки
        $newRow.find('.remove-row-btn').show();
        
        $('#departments-directions-container').append($newRow);
    });

    // Удаление строки (делегирование событий)
    $('#departments-directions-container').on('click', '.remove-row-btn', function (e) {
        e.preventDefault();
        $(this).closest('.departments-directions-row').remove();
        
        // Скрываем кнопку удаления у первой строки
        $('.departments-directions-row').first().find('.remove-row-btn').hide();
    });
});
