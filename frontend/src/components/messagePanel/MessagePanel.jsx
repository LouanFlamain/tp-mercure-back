import Channel from "./Channel";
import GroupProfile from "./GroupProfile";
import GroupSearchBar from "./GroupSearchBar";

const MessagePanel = () => {
  return (
    <div className="bg-darker h-full w-full border-grey border-2 flex flex-col justify-between rounded-r-2xl">
      <GroupProfile />
      <Channel />
      <GroupSearchBar />
    </div>
  );
};
export default MessagePanel;
