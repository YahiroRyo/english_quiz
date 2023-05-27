import styles from "./index.module.scss";

type Props = {
  icon: string;
  width: number;
  height: number;
};

export const UserIcon = ({ icon, width, height }: Props) => {
  return (
    <div
      className={styles.icon}
      style={{ backgroundImage: `url(${icon})`, width, height }}
    />
  );
};
