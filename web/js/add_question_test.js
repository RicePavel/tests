/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    var question = {
        description: '',
        options: [
            
        ]
    };
    
    $('#add_question_form').submit(function() {
        return false;
    });   
    
    $('#add_question_form #add_option_submit').click(function() {
        question.options.push({
            description: '',
            is_correct: false
        });
        renderOptions();
    });
    
    
    function renderOptions() {
        var container = $('#options');
        container.empty();
        question.options.forEach(function(item, i, arr) {
            var checked = (item.is_correct ? 'checked' : '');
            var el = $('<div>' +
                    '<input type="text" value="' + item.description + '" class="description" />' +
                    'Верный вариант:<input ' + checked + '  class="is_correct" type="checkbox" />' +
                    '<a href="#" class="up">Вверх</a>' +
                    '<a href="#" class="down">Вниз</a>' +
                    '<a href="#" class="delete">Удалить</a>' +
                    '</div>');
            el.find('.description').change(function() {
                var val = $(this).val();
                question.options[i].description = val;
                renderOptions();
            });
            el.find('.is_correct').change(function() {
                var checkbox = $(this);
                question.options[i].is_correct = checkbox.is(':checked');
                renderOptions();
            });
            el.find('.delete').click(function() {
                question.options.splice(i, 1);
                renderOptions();
                return false;
            });
            el.find('.up').click(function() {
                if (i !== 0) {
                    var obj = question.options[i];
                    question.options.splice(i, 1);
                    question.options.splice(i-1, 0, obj);
                    renderOptions();
                }
                return false;
            });
            el.find('.down').click(function() {
                if (i < (question.options.length - 1)) {
                    var obj = question.options[i];
                    question.options.splice(i, 1);
                    question.options.splice(i+1, 0, obj);
                    renderOptions();
                }
                return false;
            });
            container.append(el);
        });
    }
    
});

