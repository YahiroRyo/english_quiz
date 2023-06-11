import { MediumDarkBoldText } from "@/components/atoms/Text/MediumDarkBoldText";
import { UserIcon } from "@/components/atoms/UserIcon";
import styles from "./index.module.scss";

type Props = {
  icon: string;
  message: React.ReactNode;
};

export const ChatMessage = ({ icon, message }: Props) => {
  return (
    <div className={styles.chat}>
      <UserIcon width={60} height={60} icon={icon} />
      <MediumDarkBoldText>{message}</MediumDarkBoldText>
    </div>
  );
};
