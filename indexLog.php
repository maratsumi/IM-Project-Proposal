<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./components/output.css" />
    <title>Logs</title>
  </head>
  <body class="bg-slate-200">
    <div class="w-full h-full">
      <div
        class="h-full w-[200px] fixed z-10 top-0 left-0 bg-slate-800 overflow-x-hidden text-center shadow-md"
      >
      <h1 class="text-5xl text-slate-100 pb-10 p-5">SML</h1>
      <a href="index.html" class="text-lg block text-slate-200 px-3 py-5 mx-auto"><img src="./assets/dash.png" class="h-10 w-auto mx-auto">Dashboard</a>
      <a href="indexLogsMain.html" class="text-lg block text-slate-200 px-3 py-5 mx-auto"><img src="./assets/logs.png" class="h-10 w-auto mx-auto">Logs</a>
      <a href="indexLog.html" class="text-lg block text-slate-800 bg-slate-200 px-3 py-5 mx-auto"><img src="./assets/notes_d.png" class="h-10 w-auto mx-auto"> Notes</a>
      </div>
      <div class="h-full w-full fixed ml-11">
        <div class="ml-[200px] p-10 flex">
          <h1 class="text-4xl font-semibold">November 2022</h1>
        </div>
        <div class="ml-60">
          <table
            class="table-auto border-separate border-spacing-2 border border-slate-400"
          >
            <thead>
              <tr>
                <th class="w-44">Date Ordered</th>
                <th class="w-44">Purchase Order #</th>
                <th class="w-44">Distributor</th>
                <th class="w-44">Item Name</th>
                <th class="w-44">Item Quantity</th>
                <th class="w-44">Item Number #</th>
                <th class="w-44">Date Received</th>
                <th class="w-44">Receipient Signature</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center">
                <td class="w-44">05/25/2022</td>
                <td class="w-44">0000000001</td>
                <td class="w-44">B&J Enterprises</td>
                <td class="w-44">Trail Mix sm.</td>
                <td class="w-44">100</td>
                <td class="w-44">0000411690</td>
                <td class="w-44">06/12/2022</td>
                <td class="w-44">Dingdong Bha</td>
              </tr>
              <tr class="text-center">
                <td class="w-44">06/02/2022</td>
                <td class="w-44">0000000002</td>
                <td class="w-44">Be Kim Co.</td>
                <td class="w-44">Coffee Beans 800g</td>
                <td class="w-44">20</td>
                <td class="w-44">0000411800</td>
                <td class="w-44">07/13/2022</td>
                <td class="w-44">Nathaniel Castro</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
