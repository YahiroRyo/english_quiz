/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  trailingSlash: true,
  images: { domains: ["yappi-english-quiz.s3.ap-northeast-1.amazonaws.com"] },
};

module.exports = nextConfig;
