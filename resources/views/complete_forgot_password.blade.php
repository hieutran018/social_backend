<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Email Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
      /**
   * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
   */
      @media screen {
        @font-face {
          font-family: 'Source Sans Pro';
          font-style: normal;
          font-weight: 400;
          src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
        }

        @font-face {
          font-family: 'Source Sans Pro';
          font-style: normal;
          font-weight: 700;
          src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
        }
      }

      /**
   * Avoid browser level font resizing.
   * 1. Windows Mobile
   * 2. iOS / OSX
   */
      body,
      table,
      td,
      a {
        -ms-text-size-adjust: 100%;
        /* 1 */
        -webkit-text-size-adjust: 100%;
        /* 2 */
      }

      /**
   * Remove extra space added to tables and cells in Outlook.
   */
      table,
      td {
        mso-table-rspace: 0pt;
        mso-table-lspace: 0pt;
      }

      /**
   * Better fluid images in Internet Explorer.
   */
      img {
        -ms-interpolation-mode: bicubic;
      }

      /**
   * Remove blue links for iOS devices.
   */
      a[x-apple-data-detectors] {
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        color: inherit !important;
        text-decoration: none !important;
      }

      /**
   * Fix centering issues in Android 4.4.
   */
      div[style*="margin: 16px 0;"] {
        margin: 0 !important;
      }

      body {
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
      }

      /**
   * Collapse table borders to avoid space between cells.
   */
      table {
        border-collapse: collapse !important;
      }

      a {
        color: #1a82e2;
      }

      img {
        height: auto;
        line-height: 100%;
        text-decoration: none;
        border: 0;
        outline: none;
      }
    </style>

  </head>

  <body style="background-color: #e9ecef;">

    <!-- start preheader -->
    <div class="preheader"
      style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
      A preheader is the short summary text that follows the subject line when an email is viewed in the inbox.
    </div>
    <!-- end preheader -->

    <!-- start body -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">

      <!-- start logo -->
      <tr>
        <td align="center" bgcolor="#e9ecef">
          <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <tr>
              <td align="center" valign="top" style="padding: 36px 24px;">
                <a href="" target="_blank" style="display: inline-block;">
                  <img
                    src="https://lh3.googleusercontent.com/s7hev9tRU6huXPF0My0oDwJg07KDGg6CUKm38ubUcthGrvsxLlInuYpfe96TqCs5gspHY4zxkqWiTIPeNI0riMJCn1THTQMQT2rTyEDOzLMAq2x24D-i9_1gpNZ-kdhtHdGzd--2g-tfSy7UtinqNTij_pEQyxgSBvUkZRAt4z29rhftpVBqyz4ZxiH2UkkNynWykUETSrqWLwMYZthNFvgNbYlItxzp5zTqAHldCzS1jxpmIpAKxRHRj9EpWPoIU8k1aR9HooWXbB2eLYuiD3DMvdPGeT-ukly7IhrVx_fm5PtWTsSkO-e0obOXRB1-ifcqHY0xXT_bpVhjHKEadWrt1QIa0pY9DRrF_0ZwkhKIQ4PVm_cO8dZLOcu55iJHazDAr-E1e_TVXKwvh-aaMcgPlGTXks6vmaCBjcS3uXO-qYOvIw9XFecxkwahD01MiU_h8d7piLwr1pOlKKL8XrYgQeZuHsyoptdpoykHNXpDAXAJWZa0B_95lSKSUJAmWZaNCF91Ke1ZTVKIWXbUJD-tbj_9A947W-hHty_k3eGYrFACBwmdo-ZGlS12oyDrf9MOCUk3Y4x2UJKuzBOpIOM9AMsmdumw1Bipr0BfjORjMSI9jIJVP_frat1YFTpL6vO9OKRxtmG9NWbYsdXhPXFShK2jKXPzZ1QRROwTTY9yt5Ey65i_ziRcYINnlzj8PjE1vATTJUypVTgpjjS7oLPoaPBq3U7NojmpJamXA4pMUQSTds0EaZ2kzyR9rAXSUSyllYjaFfVic0ewIjN5QFx8vR7nHLF5mOtt-1J5DGCQLNP1nK1blzVqctcVXPpTJR-eYRdahAWkvFfzvdeQ_e8vOczG5n04Rvdk8J1ZSt9FAZgu6L1ks4l88vo_3st7TNEWdFl_Puw7p2X99pUq3-B8ojmMr-u6ZqQzsUbrRuAwDJ-nMvKdMV7P5mF5S5pD2QMHzwFzvYnYnxE0=w1204-h929-s-no?authuser=1"
                    alt="Logo" border="0" width="200"
                    style="display: block; width: 200px; max-width: 200px; min-width: 150px;">
                </a>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
        </td>
      </tr>
      <!-- end logo -->

      <!-- start hero -->
      <tr>
        <td align="center" bgcolor="#e9ecef">
          <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <tr>
              <td align="left" bgcolor="#ffffff"
                style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">
                  Đặt lại mật khẩu</h1>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
        </td>
      </tr>
      <!-- end hero -->

      <!-- start copy block -->
      <tr>
        <td align="center" bgcolor="#e9ecef">
          <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

            <!-- start copy -->
            <tr>
              <td align="left" bgcolor="#ffffff"
                style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                Xin chào {{$updatePass->first_name}} {{$updatePass->last_name}}<br>
                <p style="margin: 0;">Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản được đăng ký bởi địa chỉ email này. Đây là mật khẩu được đặt lại cho tài khoản của bạn.</p>
              </td>
            </tr>
            <!-- end copy -->

            <!-- start button -->
            <tr>
              <td align="left" bgcolor="#ffffff">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                            {{$pass}}
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <!-- end button -->

            <!-- start copy -->

            <!-- end copy -->

            <!-- start copy -->
            <tr>
              <td align="left" bgcolor="#ffffff"
                style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                <p style="margin: 0;">Rất hận hạnh được phục vụ bạn!
              </td>
            </tr>
            <!-- end copy -->

          </table>
          <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
        </td>
      </tr>
      <!-- end copy block -->
    </table>
    <!-- end body -->

  </body>

</html>