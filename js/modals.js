// pdf_viewer.js

$(document).ready(function () {
    $('#openPdfModal').click(function () {
      var pdfUrl = 'pdf_files/Student_Handbook_Final.pdf';
      $('#pdfViewer').attr('src', pdfUrl);
      $('#pdfModal').modal('show');
    });
  
    $('#closePdfModal').click(function () {
      $('#pdfModal').modal('hide');
    });
  });
  