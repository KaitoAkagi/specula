// APIを叩き、データベース情報を返す関数
// 非同期通信で実行される関数
async function callApi(url,fn) {
  const res = await fetch(url); //レスポンスを取得し、promiseを受け取る
  const users = await res.json(); //json形式に変換
  console.log(users);
  fn(users); //非同期関数は必ずpromiseで返すのでコールバック関数を使用
}