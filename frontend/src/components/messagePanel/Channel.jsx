import EndChat from "./chatBubble/EndChat";
import StartChat from "./chatBubble/StartChat";

const Channel = () => {
  return (
    <div className="w-ful h-full flex flex-col justify-end p-2 background-img">
      <StartChat />
      <EndChat />
    </div>
  );
};

export default Channel;
