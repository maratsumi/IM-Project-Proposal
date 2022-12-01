<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./components/output.css" />
    <title>Dashboard</title>
  </head>
  <body class="bg-slate-200">
    <?php require_once "config.php"; ?>
    <div class="w-full h-full flex">
      <div
        class="h-full w-[200px] fixed z-10 top-0 left-0 bg-slate-800 overflow-x-hidden text-center shadow-md"
      >
        <h1 class="text-5xl text-slate-100 pb-10 p-5">SML</h1>
        <a
          href="index.php"
          class="text-lg block text-slate-800 bg-slate-200 px-3 py-5 mx-auto"
          ><img
            src="./assets/dash_d.png"
            class="h-10 w-auto mx-auto"
          />Dashboard</a
        >

        <a
          href="indexLogsMain.html"
          class="text-lg block text-slate-200 px-3 py-5 mx-auto"
          ><img src="./assets/logs.png" class="h-10 w-auto mx-auto" />Logs</a
        >

        <a
          href="indexLog.php"
          class="text-lg block text-slate-200 px-3 py-5 mx-auto"
          ><img src="./assets/notes.png" class="h-10 w-auto mx-auto" />
          Notes</a
        >
      </div>
      <div class="ml-[200px] p-10">
        <h1 class="text-4xl font-semibold">Dashboard</h1>
      </div>
    </div>
  </body>
</html>
