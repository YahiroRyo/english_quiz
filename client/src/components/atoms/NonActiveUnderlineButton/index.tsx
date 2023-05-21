import style from "./index.module.scss";

type Props = {
  children?: React.ReactNode;
};

export const NonActiveUnderlineButton = ({ children }: Props) => {
  return <button className={style.button}>{children}</button>;
};
