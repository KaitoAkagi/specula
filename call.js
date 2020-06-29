const url = 'api.php'; // web APIのURL

// APIを叩き、データベース情報を返す関数
// 非同期通信で実行される関数
async function callApi(fn) {
  const res = await fetch(url); //レスポンスを取得し、promiseを受け取る
  const users = await res.json(); //json形式に変換
  fn(users); //非同期関数は必ずpromiseで返すのでコールバック関数を使用
}

// POST送信をする関数
async function post(url, key, value, fn) {
  const request = new FormData(); //ファームデータ作成
  // request.set(key, value); //リクエストする変数名・データをセット
  request.append(key, value);
  console.log(request);
  
  const res = await fetch(url, { method: 'POST', body: request }); //postでrequestの内容を送信
  console.log(res);
  callApi(fn);
}
