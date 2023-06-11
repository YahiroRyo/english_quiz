import { Provider } from "jotai";
import { Html, Head, Main, NextScript } from "next/document";
import { Noto_Sans_JP } from "@next/font/google";

const notojp = Noto_Sans_JP({
  weight: ["100", "200", "300", "400", "500", "600", "700", "800", "900"],
  subsets: ["latin"],
  display: "swap",
});

export default function Document() {
  return (
    <Provider>
      <Html className={notojp.className} lang="ja">
        <Head />
        <body>
          <Main />
          <NextScript />
        </body>
      </Html>
    </Provider>
  );
}
