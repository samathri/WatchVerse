<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #f0f0f0;
      }

      .popup-container {
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        text-align: center;
        width: 600px;
        height: auto;
        max-width: 100%;
        box-sizing: border-box;
      }

      .container {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 100px;
        height: 100px;
        text-align: center;
        line-height: 50px;
        border-radius: 50%;
        color: white;
        background-color: rgba(36, 136, 69, 0.185);
        margin-bottom: 20px;
      }

      .glyphicon {
        display: inline-block;
        width: 50px;
        height: 50px;
        text-align: center;
        line-height: 50px;
        border-radius: 50%;
        color: white;
        background-color: rgb(36, 136, 70);
        font-size: 30px;
      }

      h1 {
        font-weight: 400;
        font-size: 27px;
      }

      h2 {
        font-weight: 600;
        font-size: 40px;
        letter-spacing: -0.5px;
      }

      h5 {
        font-size: 21px;
      }

      .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
      }

      .email-button, .whatsapp-button {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
      }

      .email-button {
        background-color: black;
        color: white;
        margin-right: 10px; 
      }

      .whatsapp-button {
        background-color: #ededed;
        color: black;
        margin-left: 10px;
      }

      .email-button i {
        margin-right: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 25px;
        height: 25px;
        background-color: black;
        border-radius: 25%;
        color: white;
      }

      .whatsapp-button i {
        margin-right: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 25px;
        height: 25px;
        background-color: #25D366;
        border-radius: 25%;
        color: white;
        font-size: 16px;
      }

      h3 {
        font-size: 15px;
      }

      @media (max-width: 1024px) and (min-width: 768px) {
        .popup-container {
          width: auto;
          padding: 25px;
        }

        h1 {
          font-size: 24px;
        }

        h2 {
          font-size: 35px;
        }
      }

      @media (max-width: 768px) {
        .popup-container {
          width: auto;
          padding: 20px;
        }

        h1 {
          font-size: 22px;
        }

        h2 {
          font-size: 32px;
        }
      }

      @media (max-width: 480px) {
        .popup-container {
          width: auto;
        }

        h1 {
          font-size: 20px;
        }

        h2 {
          font-size: 28px;
        }
      }
    </style>
  </head>
  <body>
    <div class="popup-overlay">
      <div class="popup-container">
        <div class="container">
          <span class="glyphicon" style="color: white;">&#xe013;</span>
        </div>
        <div>
          <h1>Payment Success!</h1>
          <h2>LKR 57,100.00</h2>
          <hr>
          <br>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-family: poppins; color: #707070;">Ref Number</h5>
            <h5 style="margin: 0; font-family: poppins; color: #000000; font-weight: 600; letter-spacing: 0.5px;">000085752257</h5>
          </div>
          <br>
          <br>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-family: poppins; color: #707070;">Payment Time</h5>
            <h5 style="margin: 0; font-family: poppins; color: #000000; font-weight: 600; letter-spacing: 0.5px;">25-02-2023, 13:22:16</h5>
          </div>
          <br>
          <br>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-family: poppins; color: #707070;">Payment Method</h5>
            <h5 style="margin: 0; font-family: poppins; color: #000000; font-weight: 600; letter-spacing: 0.5px;">Bank Transfer</h5>
          </div>
          <br>
          <br>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-family: poppins; color: #707070;">Sender Name</h5>
            <h5 style="margin: 0; font-family: poppins; color: #000000; font-weight: 600; letter-spacing: 0.5px;">Ben Parker</h5>
          </div>
          <br>
          <br>
          <hr style="border: none; border-top: 2px dashed #ededed; margin: 20px 0;">
          <br>

          <div style="display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-family: poppins; color: #707070;">Amount</h5>
            <h5 style="margin: 0; font-family: poppins; color: #000000; font-weight: 600; letter-spacing: 0.5px;">LKR 57,100.00</h5>
          </div>

          <div class="button-container">
            <button class="email-button">
              <i class="bi bi-envelope"></i>Email the Receipt
            </button>
            <h3 >or</h3>
            <button class="whatsapp-button">
              <i class="bi bi-whatsapp"></i>WhatsApp the Receipt
            </button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
