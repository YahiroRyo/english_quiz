import { Provider } from "jotai";
import { Html, Head, Main, NextScript } from "next/document";

export default function Document() {
  return (
    <Provider>
      <Html lang="ja">
        <Head />
        <body>
          <Main />
          <NextScript />
        </body>
      </Html>
    </Provider>
  );
}
