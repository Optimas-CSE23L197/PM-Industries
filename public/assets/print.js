function exportHTML(type, selector, options = null)
{
    let printType = null;
    let filename = null;
    
    if (options && typeof options === 'object') {
        printType = options.printType || null;
        filename = options.filename || null;
    }

    if (printType == 1) {
        selector = '#type1-view';
    } else if (printType == 2) {
        selector = '#type2-view';
    }

    let html = $(selector).html();
    let table = $(selector).find('table');
    let tableFilename = table.data('tablename');
    let orientation = table.data('pageo') || 'p';
    let pdfmode = table.data('pdfmode') || 'download';

    filename = filename || tableFilename || 'Package_' + new Date().toISOString().slice(0, 10).replace(/-/g, '');

    // Print - Browser print window
    if(type === 'print')
    {
        let w = window.open('', '_blank');
        w.document.write('<base href="' + window.location.origin + '/">' + html);
        w.document.close();

        function waitForImagesThenPrint() {
            let images = w.document.images;
            let total = images.length;

            if (total === 0) {
                w.focus();
                w.print();
                return;
            }

            let loaded = 0;
            function checkDone() {
                loaded++;
                if (loaded === total) {
                    w.focus();
                    w.print();
                }
            }

            Array.from(images).forEach(function (img) {
                if (img.complete) {
                    checkDone();
                } else {
                    img.addEventListener('load', checkDone);
                    img.addEventListener('error', checkDone);
                }
            });
        }

        setTimeout(waitForImagesThenPrint, 50);

        w.onafterprint = function () {
            w.close();
        }
        return;
    }

    // PDF/Excel/Word - Server POST
    let actionUrl = '';
    
    // Package print ke liye alag URL
    if (printType == 1 || printType == 2) {
        actionUrl = '/package-export/' + type;
    } else {
        actionUrl = '/export/' + type;
    }

    let form = $('<form>', {
        method : 'POST',
        action : actionUrl
    });
    
    form.append($('<input>', {
        type : 'hidden',
        name : '_token',
        value : $('meta[name="csrf-token"]').attr('content')
    }));
    form.append($('<input>', {
        type : 'hidden',
        name : 'html',
        value : html
    }));
    form.append($('<input>', {
        type : 'hidden',
        name : 'filename',
        value : filename
    }));
    form.append($('<input>', {
        type : 'hidden',
        name : 'orientation',
        value : orientation
    }));
    form.append($('<input>', {
        type : 'hidden',
        name : 'pdfmode',
        value : pdfmode
    }));
    
    if(type === 'pdf' && pdfmode === 'view') {
        form.attr('target', '_blank');
    }
    
    $('body').append(form);
    form.submit();
    form.remove();
}