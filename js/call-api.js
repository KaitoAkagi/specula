/**
 * API（api.php）を叩く関数
 * @param {string} url api.phpまでの相対アドレス（パラメータ付き）を指定する
 *     例）url = "api.php?type=user"
 * @param {Function} fn api.phpから取得した情報を使って実行する関数
 */

async function callApi(url, fn) {
  const res = await fetch(url) // レスポンスを取得し、promiseを受け取る
  const dates = await res.json() // json形式に変換
  console.log(dates) // 所得したデータをchrome devtoolsで確認
  fn(dates)
}
