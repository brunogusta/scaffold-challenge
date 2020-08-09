<h1 align="center">Watch&Learn</h1>

<div>
  <h2>:zap: How to use</h2>
</div>

<ul>
  <li><h2>Requirements:</h2></li>
  <li>Apache</li>
  <li>PHP</li>
  <li>Laravel</li>
  <li>MySQL</li>
  <li>Mailtrap</li>

</ul>

---

<ul>
  <li>Start by cloning or downloading this repository.</li>
  <li>
    In your folder, install the dependencies using your preferred package manager (npm, yarn).
  </li>
  <li>
    In `.env` file make the following modifications:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=YOUR_DATABASE_NAME
    DB_USERNAME=YOUR_DATABASE_USERNAME
    DB_PASSWORD=YOUR_DATABASE_PASSWORD

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=YOUR_MAILTRAP_USERNAME
    MAIL_PASSWORD=YOUR_MAILTRAP_PASSWORD
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS=null
    MAIL_FROM_NAME="${APP_NAME}"

  </li>
   <li>
      Run the command to update configurations: 
      
      php artisan config:cache
  </li>
  <li>
      Run the next commands to start the aplication:

      npm run dev
      php artisan serve
      php artisan migrate
      php artisan db:seed

  </li>
   <li>
      The aplication is ready to explore.
  </li>
</ul>

<div id='license'>
  <h2>:page_facing_up: License</h2>
</div>

MIT

---

<p align='center'>
  Made with :hearts: by Bruno Gustavo.
</p>
