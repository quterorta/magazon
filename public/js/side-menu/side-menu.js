$(document).ready(function() {
    
    $('#side_menu_open_button').click(function() {
        var sideMenuId = $(this).data('open-menu');
        var sideMenu = $('#'+sideMenuId+'');
        
        if (sideMenu.is(':visible')) {
            sideMenu.hide(200);
        } else if (sideMenu.is(':hidden')) {
            sideMenu.show(200);
        }
    });
    
    $('.side-menu-overlay').click(function() {
        var closeMenu = $('#side_menu');
        var chapterMenus = $('.chapter_level_container');
        var categoryMenus = $('.category_level_container');
        closeMenu.hide(200);
        chapterMenus.each(function(){
               $(this).hide(); 
            });
        categoryMenus.each(function(){
            $(this).hide(); 
        });
    });
    
    $('.close-main-level-btn').click(function() {
        var closeMenuId = $(this).data('close-menu');
        var closeMenu = $('#'+closeMenuId+'');
        var chapterMenus = $('.chapter_level_container');
        var categoryMenus = $('.category_level_container');
        closeMenu.hide(200);
        chapterMenus.each(function(){
               $(this).hide(); 
            });
        categoryMenus.each(function(){
            $(this).hide(); 
        });
    });
    
    $('.main_level_body__button').click(function() {
        var chapterMenuId = $(this).data('open-menu');
        var chapterMenu = $('#'+chapterMenuId+'');
        var chapterMenus = $('.chapter_level_container');
        var categoryMenus = $('.category_level_container');
        
        if (chapterMenu.is(':visible')) {
            chapterMenus.each(function(){
               $(this).hide(); 
            });
            categoryMenus.each(function(){
               $(this).hide(); 
            });
        } else if (chapterMenu.is(':hidden')) {
            chapterMenus.each(function(){
               $(this).hide(); 
            });
            categoryMenus.each(function(){
               $(this).hide(); 
            });
            chapterMenu.show(200);
        }
    });
    
    $('.close-chapter-level-btn').click(function() {
        var closeMenuId = $(this).data('close-menu');
        var closeMenu = $('#'+closeMenuId+'');
        var categoryMenus = $('.category_level_container');
        closeMenu.hide(200);
        categoryMenus.each(function(){
            $(this).hide(); 
        });
    });
    
    $('.chapter_level_body__button').click(function() {
        var categoryMenuId = $(this).data('open-menu');
        var categoryMenu = $('#'+categoryMenuId+'');
        var categoryMenus = $('.category_level_container');
        
        if (categoryMenu.is(':visible')) {
            categoryMenus.each(function(){
               $(this).hide(); 
            });
        } else if (categoryMenu.is(':hidden')) {
            categoryMenus.each(function(){
               $(this).hide(); 
            });
            categoryMenu.show(200);
        }
    });
    
    $('.close-category-level-btn').click(function() {
        var closeMenuId = $(this).data('close-menu');
        var closeMenu = $('#'+closeMenuId+'');
        closeMenu.hide(200);
    });
    
});
